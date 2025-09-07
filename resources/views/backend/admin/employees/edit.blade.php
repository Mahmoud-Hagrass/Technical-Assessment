@extends('backend.admin.master')
@section('title', 'Employees Edit')
@section('content')
    <div class="container px-6 mx-auto grid max-w-4xl">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Add New Employee
        </h2>

        <form action="{{ route('admin.employees.update' , $employee->id) }}" method="POST" class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            @csrf
            @method('PUT')

            <label class="block mb-6 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Name</span>
                <input
                    name="name"
                    type="text"
                    class="block w-full mt-1 text-sm rounded-md dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Enter employee name" value="{{ $employee->name }}"/>
                    @error('name')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
            </label>

            <label class="block mb-6 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Email</span>
                <input
                    name="email"
                    type="email"
                    class="block w-full mt-1 text-sm rounded-md dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Enter employee email" value="{{ $employee->email }}"/>
                    @error('email')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
            </label>

            <label class="block mb-6 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Salary</span>
                <input
                    name="salary"
                    type="number"
                    class="block w-full mt-1 text-sm rounded-md dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Enter employee salary" value="{{ $employee->salary }}"/>
                    @error('salary')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
            </label>

           <label class="block mb-8 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Department</span>
                <select
                    name="department_id"
                    id="department-select"
                    class="block w-full mt-1 text-sm rounded-md dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-select">
                    <option value="" selected disabled>Select department</option>
                    @foreach($departments as $department)
                        <option @selected($employee->department_id === $department->id) value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                @error('department_id')
                        <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </label>


            <button
                type="submit"
                class="px-6 py-3 font-semibold text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Save
            </button>
        </form>
    </div>

    @push('css')
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('js')

    <!-- Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

     <script>
        $(document).ready(function () {

            // Debounce function
            function debounce(func, wait) {
                let timeout;
                return function (...args) {
                    const context = this;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }

            $('#department-select').select2({
                placeholder: 'Select department',
                allowClear: true,
                width: '100%',
                minimumInputLength: 0,
                ajax: {
                    transport: debounce(function (params, success, failure) {
                        if (!params.data.q || params.data.q.trim() === '') {
                            return;
                        }
                        $.ajax(params).then(success).catch(failure);
                    }, 500), // 500ms delay before request is sent
                    url: '{{ route('admin.departments.search') }}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: params.term || ''
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                }
            });
        });
    </script>

    @endpush
@endsection

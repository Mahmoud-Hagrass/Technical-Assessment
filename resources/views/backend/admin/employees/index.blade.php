@extends('backend.admin.master')
@section('title', 'Employees')
@section('content')

<div class="container grid px-6 mx-auto">
    <!-- Page Title + Buttons -->
    <div class="d-flex align-items-center justify-content-between my-4">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Employees
        </h2>
        <div class="d-flex align-items-center">
            <!-- Export Excel -->
            <a href="{{ route('admin.employees.export-excel') }}"
               class="btn btn-sm text-white shadow-sm mr-2"
               style="background-color: #10b981; text-decoration: none; min-width: 120px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;"
               onmouseover="this.style.backgroundColor='#059669';"
               onmouseout="this.style.backgroundColor='#10b981';">
                Export Excel
            </a>
            <!-- Export PDF -->
            <a href="{{ route('admin.employees.export-pdf') }}"
               class="btn btn-sm text-white shadow-sm mr-2"
               style="background-color: #f43f5e; text-decoration: none; min-width: 120px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;"
               onmouseover="this.style.backgroundColor='#e11d48';"
               onmouseout="this.style.backgroundColor='#f43f5e';">
                Export PDF
            </a>
            <!-- Add Employee -->
            <a href="{{ route('admin.employees.create') }}"
               class="btn btn-sm text-white shadow-sm"
               style="background-color: #6366f1; text-decoration: none; min-width: 120px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;"
               onmouseover="this.style.backgroundColor='#4f46e5';"
               onmouseout="this.style.backgroundColor='#6366f1';">
                Add Employee
            </a>
        </div>
    </div>

    @if (session('success') || session('error'))
        <div id="session-message"
             class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }} mb-4 p-3 rounded"
             style="font-weight: bold;">
            {{ session('success') ?? session('error') }}
        </div>
    @endif

    <!-- Employees Table -->
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Department</th>
                        <th class="px-4 py-3">Salary</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($employees as $employee)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{ $loop->iteration + $employees->firstItem() - 1 }}</td>
                            <td class="px-4 py-3">{{ $employee->name }}</td>
                            <td class="px-4 py-3">{{ $employee->email }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ $employee->department_name }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $employee->salary }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <a href="{{ route('admin.employees.edit', $employee->id) }}"
                                       class="flex items-center justify-between px-2 py-2 text-sm font-medium text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                       aria-label="Edit">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>

                                    <a href="javascript:void(0);" onclick="confirmDelete({{ $employee->id }})"
                                       class="flex items-center justify-between px-2 py-2 text-sm font-medium text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                       aria-label="Delete">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                  d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                    </a>

                                    <form id="form_delete_{{ $employee->id }}"
                                          action="{{ route('admin.employees.destroy', $employee->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No Data Found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $employees->render('pagination::bootstrap-4') }}
        </div>

        <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
            <span class="flex items-center col-span-3">
                Showing {{ $employees->firstItem() }}-{{ $employees->lastItem() }} of {{ $employees->total() }}
            </span>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(employeeId){
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form_delete_' + employeeId).submit();
                }
            });
        }

        // اختفاء رسالة السيشن بعد 5 ثواني
        document.addEventListener('DOMContentLoaded', function () {
            const msg = document.getElementById('session-message');
            if (msg) {
                setTimeout(() => {
                    msg.style.display = 'none';
                }, 5000);
            }
        });

        // ✅ Excel Polling
        @if (session('file_name'))
        (function(){
            var fileName = '{{ session('file_name') }}';
            var pollingInterval = setInterval(function() {
                fetch('/admin/employees/check-excel-file-existence/' + fileName)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            clearInterval(pollingInterval);
                            window.location.href = '/admin/employees/download/' + fileName;

                            Swal.fire({
                                title: 'Excel Ready!',
                                text: 'Your Excel file is downloading now.',
                                icon: 'success',
                                timer: 3000
                            });
                        }
                    });
            }, 5000);
        })();
        @endif

        // ✅ PDF Polling
        @if (session('pdf_file_name'))
        (function(){
            let pdfFileName = '{{ session('pdf_file_name') }}';

            // Show processing message
            const processingAlert = document.createElement('div');
            processingAlert.className = "alert alert-info mt-3";
            processingAlert.innerText = "📄 Your PDF export is being processed. The download will start automatically when ready.";
            document.querySelector('.container').prepend(processingAlert);

            setTimeout(() => {
                processingAlert.remove();
            }, 5000);

            let polling = setInterval(() => {
                fetch('/admin/employees/check-pdf-file-existence/' + pdfFileName)
                    .then(res => res.json())
                    .then(data => {
                        if (data.exists) {
                            clearInterval(polling);
                            window.location.href = '/admin/employees/download-pdf/' + pdfFileName;

                            Swal.fire({
                                title: 'PDF Ready!',
                                text: 'Your PDF is downloading now.',
                                icon: 'success',
                                timer: 3000
                            });
                        }
                    });
            }, 5000);
        })();
        @endif
    </script>
@endpush

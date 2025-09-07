<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr>
            <th style="border: 1px solid #000; padding: 5px;">ID</th>
            <th style="border: 1px solid #000; padding: 5px;">Name</th>
            <th style="border: 1px solid #000; padding: 5px;">Email</th>
            <th style="border: 1px solid #000; padding: 5px;">Department</th>
            <th style="border: 1px solid #000; padding: 5px;">Salary</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
            <tr>
                <td style="border: 1px solid #000; padding: 5px;">{{ $employee->id }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{ $employee->name }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{ $employee->email }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{ $employee->department->name ?? '-' }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{ $employee->salary }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

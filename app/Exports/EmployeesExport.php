<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
class EmployeesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithChunkReading
{
    public function query()
    {
        return Employee::query()->with('department');
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Department',
            'Salary',
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->id,
            $employee->name,
            $employee->email,
            $employee->department ? $employee->department->name : 'N/A',
            $employee->salary,
        ];
    }
}

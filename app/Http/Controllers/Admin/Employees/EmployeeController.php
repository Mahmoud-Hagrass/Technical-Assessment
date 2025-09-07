<?php

namespace App\Http\Controllers\Admin\Employees;

use App\Exports\EmployeesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Jobs\ExportEmployeesPdfJob;
use App\Services\Department\DepartmentService;
use App\Services\Employee\EmployeeService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    protected $employeeService ;
    protected $departmentService ;

    public function __construct(EmployeeService $employeeService , DepartmentService $departmentService)
    {
        $this->employeeService   = $employeeService ;
        $this->departmentService = $departmentService ;
    }

    public function index()
    {
        $employees = $this->employeeService->getEmployeesWithDepartments() ;
        if(!$employees){
            return redirect()->back()->with(['error' , 'Error!']) ;
        }

        return view('backend.admin.employees.index' , compact('employees')) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = $this->departmentService->getDepartmentsPaginated() ;
        if(!$departments){
            return redirect()->back()->with(['error' , 'Error!']) ;
        }

        return view('backend.admin.employees.create' , compact('departments')) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->only(['name' , 'email' , 'salary' , 'department_id']) ;
        $employeeCreated = $this->employeeService->createEmployee($data) ;

        if(!$employeeCreated){
            return redirect()->back()->with(['error' , 'Not Created!']) ;
        }

        return redirect()->back()->with(['success' , 'Created Successfully!']) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = $this->employeeService->getEmployeeById($id) ;

        if(!$employee){
            abort(404) ;
        }

        $departments = $this->departmentService->getDepartmentsPaginated() ;

        if(!$departments){
            abort(404) ;
        }

        return view('backend.admin.employees.edit' , compact(['employee' , 'departments'])) ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEmployeeRequest $request, string $id)
    {
        $data = $request->only(['name' , 'email' , 'salary' , 'department_id']) ;
        $updatedEmployee = $this->employeeService->updateEmployee($id , $data) ;

        if(!$updatedEmployee){
            return redirect()->back()->with(['error' , 'Error!']) ;
        }

        return redirect()->back()->with(['success' => 'Updated Successfully!']) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroiedEmployee = $this->employeeService->destroyEmployee($id) ;
        if(!$destroiedEmployee){
            return redirect()->back()->with(['error' , 'Error!']) ;
        }
        return redirect()->back()->with(['error' , 'Deleted Successfully!']) ;
    }

    public function export()
    {
        try {
            ini_set('memory_limit', '512M');
            set_time_limit(300);


            $fileName = 'employees_' . time() . '.xlsx';
            $filePath = 'exports/' . $fileName;

            Excel::queue(new EmployeesExport, $filePath, 'public', \Maatwebsite\Excel\Excel::XLSX);

            return back()->with('success', 'Export is being processed. The file will download automatically when ready.')
                        ->with('file_name', $fileName);
        } catch (\Exception $e) {
            Log::error('Excel export failed: ' . $e->getMessage());
            return back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }


    public function checkExcelFileExistence($fileName)
    {
        $filePath = 'exports/' . $fileName;

        $exists = Storage::disk('public')->exists($filePath);

        return response()->json(['exists' => $exists]);
    }

    public function download($fileName)
    {
        $filePath = 'exports/' . $fileName;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        return Storage::disk('public')->download($filePath);
    }

    public function exportPdf()
    {
        $fileName = 'employees_' . Str::uuid(). '_' . time() . '.pdf';

        ExportEmployeesPdfJob::dispatch($fileName);

        return back()
            ->with('success', 'Export is being processed. The file will download automatically when ready.')
            ->with('pdf_file_name', $fileName);
    }

    public function checkPdfFileExistence($fileName)
    {
         return response()->json([
            'exists' => Storage::disk('public')->exists("exports/pdf/{$fileName}")
        ]);
    }

    public function downloadPdf($fileName)
    {
        $path = "exports/pdf/{$fileName}";

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return Storage::disk('public')->download($path);
    }
}

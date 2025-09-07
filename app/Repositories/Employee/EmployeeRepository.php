<?php

namespace App\Repositories\Employee;

use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeInterface;
use Illuminate\Support\Facades\DB;

class EmployeeRepository implements EmployeeInterface
{
    public function getEmployeesWithDepartments()
    {
        // $employees = Employee::query()
        //                 ->with(['department' => function($query){
        //                     return $query->select(['id' , 'name']) ;
        //                 }])
        //                 ->select(['id' ,'name','email','department_id','salary'])
        //                 ->paginate(10) ;
        // return $employees ;

        $employees = DB::table('employees')
                 ->select(['employees.id' , 'employees.name' , 'employees.email' , 'departments.name as department_name' , 'employees.salary'])
                 ->leftJoin('departments' , 'employees.department_id' , '=' , 'departments.id')
                 ->paginate(10) ;

        if($employees->isEmpty()){
            return false ;
        }

        return $employees ;
    }


    public function createEmployee($data)
    {
        $employee = Employee::create([
            'name'           => $data['name'] ,
            'email'          => $data['email'] ,
            'salary'         => $data['salary'] ,
            'department_id'  => $data['department_id'] ,
        ]) ;

        if(!$employee){
            return false  ;
        }

        return $employee ;
    }


    public function getEmployeeById($id)
    {
        $employee = Employee::with(['department'])->find($id) ;

        if(!$employee){
            return false ;
        }

        return $employee ;
    }

    public function updateEmployee($employee , $data)
    {
        $updatedEmploee = $employee->update([
            'name'          => $data['name'] ,
            'email'         => $data['email'] ,
            'salary'        => $data['salary'] ,
            'department_id' => $data['department_id'] ,
        ]) ;

        if(!$updatedEmploee){
            return false ;
        }

        return $updatedEmploee ;
    }

    public function destroyEmployee($employee)
    {
        $deletedEmployee = $employee->delete() ;

        if(!$deletedEmployee){
            return false ;
        }

        return true ;
    }
}

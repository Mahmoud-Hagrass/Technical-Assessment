<?php

namespace App\Services\Employee;

use App\Repositories\Interfaces\EmployeeInterface;

class EmployeeService
{
    protected $employeeRepository ;

    public function __construct(EmployeeInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository ;
    }


    public function getEmployeesWithDepartments()
    {
        return $this->employeeRepository->getEmployeesWithDepartments() ;
    }


    public function createEmployee($data)
    {
        return $this->employeeRepository->createEmployee($data) ;
    }

    public function getEmployeeById($id)
    {
        return $this->employeeRepository->getEmployeeById($id) ;
    }

    public function updateEmployee($id , $data)
    {
        $employee = Self::getEmployeeById($id) ;

        if(!$employee){
            return false ;
        }

        return $this->employeeRepository->updateEmployee($employee , $data) ;
    }

    public function destroyEmployee($id)
    {
        $employee = Self::getEmployeeById($id) ;
        if(!$employee){
            return false ;
        }

        return $this->employeeRepository->destroyEmployee($employee) ;
    }
}

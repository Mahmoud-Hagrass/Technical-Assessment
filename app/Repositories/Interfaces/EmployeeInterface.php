<?php

namespace App\Repositories\Interfaces;

interface EmployeeInterface
{
    public function getEmployeesWithDepartments() ;
    public function createEmployee($data) ;
    public function getEmployeeById($id) ;
    public function updateEmployee($employee , $data) ;
    public function destroyEmployee($employee)  ;
}

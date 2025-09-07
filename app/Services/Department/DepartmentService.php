<?php

namespace App\Services\Department;

use App\Repositories\Interfaces\DepartmentInterface;

class DepartmentService
{

    protected $departmentRepository ;

    public function __construct(DepartmentInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository ;
    }

    public function getDepartmentsPaginated()
    {
        return $this->departmentRepository->getDepartmentsPaginated() ;
    }
}

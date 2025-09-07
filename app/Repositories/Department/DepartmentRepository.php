<?php

namespace App\Repositories\Department;

use App\Models\Department;
use App\Repositories\Interfaces\DepartmentInterface;

class DepartmentRepository implements DepartmentInterface
{
    public function getDepartmentsPaginated()
    {
        $departments = Department::query()
                            ->latest()
                            ->take(10)
                            ->select(['id' , 'name'])
                            ->get() ;
        if($departments->isEmpty()){
            return false ;
        }
        return $departments ;
    }
}

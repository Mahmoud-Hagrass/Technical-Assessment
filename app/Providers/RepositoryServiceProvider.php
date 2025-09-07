<?php

namespace App\Providers;

use App\Models\Department;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\Interfaces\DepartmentInterface;
use App\Repositories\Interfaces\EmployeeInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(EmployeeInterface::class , EmployeeRepository::class) ;
        $this->app->bind(DepartmentInterface::class , DepartmentRepository::class) ;
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

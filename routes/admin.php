<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Departments\DepartmentController;
use App\Http\Controllers\Admin\Emploees\EmploeeController;
use App\Http\Controllers\Admin\Employees\EmployeeController;
use App\Models\Department;
use Illuminate\Support\Facades\Route;



Route::group(['as' => 'admin.'] , function(){
    Route::prefix('/dashboard')->name('dashboard.')->group(function(){
        Route::get('/' , [DashboardController::class , 'index'])->name('index') ;
    }) ;

    Route::prefix('/employees')->name('employees.')->group(function(){
        Route::controller(EmployeeController::class)->group(function(){
            Route::get('/export-excel'                          , 'exportExcel')->name('export-excel') ;
            Route::get('/check-excel-file-existence/{fileName}' , 'checkExcelFileExistence')->name('check-file-existence') ;
            Route::get('/download/{fileName}'                   , 'download')->name('file-download');

            Route::get('/export-pdf'                            , 'exportPdf')->name('export-pdf') ;
            Route::get('/check-pdf-file-existence/{fileName}'   , 'checkPdfFileExistence')->name('check-pdf');
            Route::get('/download-pdf/{fileName}'               , 'downloadPdf')->name('download-pdf');
        }) ;
    }) ;

    Route::resource('/employees' , EmployeeController::class) ;

    Route::get('/departments/search' , [DepartmentController::class, 'search'])->name('departments.search') ;
    Route::resource('/departments', DepartmentController::class) ;

});

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/companies');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/companies', [App\Http\Controllers\CompanyController::class, 'index'])->name('companies');

    Route::get('/get-companies', [App\Http\Controllers\CompanyController::class, 'get'])->name('get.company');
    Route::get('/get-company/{param}', [App\Http\Controllers\CompanyController::class, 'getOne']);
    Route::delete('/company/{id}', [App\Http\Controllers\CompanyController::class, 'delete'])->name('delete.company');
    Route::post('/companies', [App\Http\Controllers\CompanyController::class, 'add'])->name('create.companies');

    Route::get('/export-companies', [App\Http\Controllers\CompanyController::class, 'exportPdf'])->name('export.companies');

    Route::get('/employees', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employees');

    Route::get('/get-employees', [App\Http\Controllers\EmployeeController::class, 'get'])->name('get.employee');
    Route::get('/get-employee/{param}', [App\Http\Controllers\EmployeeController::class, 'getOne']);
    Route::delete('/employee/{id}', [App\Http\Controllers\EmployeeController::class, 'delete'])->name('delete.employee');
    Route::post('/employees', [App\Http\Controllers\EmployeeController::class, 'add'])->name('create.employees');

    Route::get('/export-employees', [App\Http\Controllers\EmployeeController::class, 'exportPdf'])->name('export.employees');

    Route::post('/companies/import-excel', [App\Http\Controllers\CompanyController::class, 'importExcel'])->name('import.companies');
    Route::post('/employees/import-excel', [App\Http\Controllers\EmployeeController::class, 'importExcel'])->name('import.employees');
});

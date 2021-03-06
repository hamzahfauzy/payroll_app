<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\SallaryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AllowanceController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeePeriodController;

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

Route::middleware('installed')->group(function () {
    Auth::routes([
        'register' => false,
        'reset' => false,
        'verify' => false
    ]);

    Route::middleware('auth')->group(function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::match(['get', 'post'], 'edit-profile', [App\Http\Controllers\HomeController::class, 'edit_profile'])->name('edit-profile');

        Route::middleware('admin')->group(function () {
            Route::match(['get', 'post'], 'positions/import', [App\Http\Controllers\PositionController::class, 'import'])->name('positions.import');
            Route::match(['get', 'post'], 'employees/import', [App\Http\Controllers\EmployeeController::class, 'import'])->name('employees.import');
            Route::match(['get', 'post'], 'sallaries/import', [App\Http\Controllers\SallaryController::class, 'import'])->name('sallaries.import');
            
            Route::resource('positions', PositionController::class);
            Route::get('employees/delete-all', [EmployeeController::class,'deleteAll'])->name('employees.delete-all');
            Route::post('employee/bulk-delete', [App\Http\Controllers\EmployeeController::class, 'bulkDelete'])->name('employee.bulk-delete');
            Route::get('employees/export', [App\Http\Controllers\EmployeeController::class, 'export'])->name('employees.export');
            Route::resource('employees', EmployeeController::class);
            Route::resource('allowances', AllowanceController::class);
            Route::resource('sallaries', SallaryController::class);
            Route::resource('periods', PeriodController::class);
            Route::resource('attendances', AttendanceController::class);
            Route::match(['get', 'post'], 'employee-periods/{employeePeriod}/sallary-panel', [App\Http\Controllers\EmployeePeriodController::class, 'sallaryPanel'])->name('employee-periods.sallary-panel');
            Route::match(['get', 'post'], 'employee-periods/import', [App\Http\Controllers\EmployeePeriodController::class, 'import'])->name('employee-periods.import');
            Route::get('employee-periods/download', [App\Http\Controllers\EmployeePeriodController::class, 'download'])->name('employee-periods.download');
            Route::post('employee-periods/bulk-download', [App\Http\Controllers\EmployeePeriodController::class, 'bulkdownload'])->name('employee-periods.bulk-download');
            Route::get('employee-periods/{employeePeriod}/pay', [App\Http\Controllers\EmployeePeriodController::class, 'pay'])->name('employee-periods.pay');
            Route::resource('employee-periods', EmployeePeriodController::class);
        });
    });

    Route::get("payroll/{employeePeriod}", [App\Http\Controllers\HomeController::class, 'payroll'])->name('payroll');
});

Route::middleware('installation')->group(function () {
    Route::match(['get', 'post'], 'installation', [App\Http\Controllers\HomeController::class, 'installation'])->name('installation');
});

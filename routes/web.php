<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\SallaryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AllowanceController;
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

Route::middleware('installed')->group(function(){
    Auth::routes([
        'register' => false,
        'reset' => false, 
        'verify' => false
    ]);

    Route::middleware('auth')->group(function(){
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('edit-profile', [App\Http\Controllers\HomeController::class, 'index'])->name('edit-profile');
        
        Route::middleware('admin')->group(function(){
            Route::resource('positions', PositionController::class);
            Route::resource('employees', EmployeeController::class);
            Route::resource('allowances', AllowanceController::class);
            Route::resource('sallaries', SallaryController::class);
            Route::resource('periods', PeriodController::class);
            Route::match(['get','post'],'employee-periods/{employeePeriod}/sallary-panel', [App\Http\Controllers\EmployeePeriodController::class, 'sallaryPanel'])->name('employee-periods.sallary-panel');
            Route::resource('employee-periods', EmployeePeriodController::class);
        });
    });
    
});

Route::middleware('installation')->group(function(){
    Route::match(['get','post'], 'installation', [App\Http\Controllers\HomeController::class, 'installation'])->name('installation');
});

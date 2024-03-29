<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ServiceController;
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

// dashboard
Route::prefix('dashboard')->group(function ()
{
    Route::get('/', fn() => dd('dashboard'));

    // services
    Route::controller(ServiceController::class)->prefix('services')->group(function ()
    {
        Route::get('/', 'index');
        Route::get('create', 'create');
        Route::post('create', 'store');
        Route::get('edit/{id}', 'edit');
        Route::post('edit/{id}', 'update');
        Route::post('delete/{id}', 'destroy');
        Route::get('{id}', 'show');
    });

    // employees
    Route::controller(EmployeeController::class)->prefix('employees')->group(function ()
    {
        Route::get('/', 'index');
        Route::get('create', 'create');
        Route::post('create', 'store');
        Route::get('edit/{id}', 'edit');
        Route::post('edit/{id}', 'update');
        Route::post('delete/{id}', 'destroy');
        Route::get('{id}', 'show');
    });
});

// front
Route::controller(FrontController::class)->group(function ()
{
    Route::get('/', 'index')->name('reservation-index');
    Route::get('{serviceId}', 'form')->name('reservation-form');
    Route::get('{serviceId}/{employeeId}', 'form')->name('reservation-form-employee');
    Route::post('{serviceId}', 'store')->name('reservation-store');
});

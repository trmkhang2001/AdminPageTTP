<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Employees\CategoryEmployeeController;
use App\Http\Controllers\Employees\EmployeeController;
use App\Models\CategoryEmployee;
use App\Models\Customer\InfoCustomer;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});
Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        $employee = Employee::orderBy('id', 'asc')->get();
        $customer = InfoCustomer::orderBy('id', 'asc')->get();
        return view('layouts.dashboard', compact('employee', 'customer'));
    })->name('dashboard');
    Route::controller(EmployeeController::class)->prefix('employee')->group(function () {
        Route::get('', 'index')->name('employee');
        Route::get('create', 'create')->name('employee.create');
        Route::post('store', 'store')->name('employee.store');
        Route::get('show/{id}', 'show')->name('employee.show');
        Route::get('edit/{id}', 'edit')->name('employee.edit');
        Route::post('update/{id}', 'update')->name('employee.update');
        Route::delete('destroy/{id}', 'destroy')->name('employee.destroy');
    });
    Route::controller(CategoryEmployeeController::class)->prefix('category')->group(function () {
        Route::get('', 'index')->name('category');
        Route::get('create', 'create')->name('category.create');
        Route::post('store', 'store')->name('category.store');
        Route::get('edit/{id}', 'edit')->name('category.edit');
        Route::post('update/{id}', 'update')->name('catetgory.update');
        Route::delete('destroy/{id}', 'destroy')->name('catetgory.destroy');
    });
    Route::controller(CustomerController::class)->prefix('customer')->group(function () {
        Route::get('', 'index')->name('customer');
        Route::get('create', 'create')->name('customer.create');
        Route::post('store', 'store')->name('customer.store');
    });
});

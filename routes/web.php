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

Auth::routes();

Route::get('/recognition', function () {
    return view('recognition');
});    
    
Route::middleware(['auth'])->group(function () {
    Route::resource('/employees', App\Http\Controllers\EmployeeController::class);
    Route::resource('/departments', App\Http\Controllers\DepartmentController::class);
    Route::resource('/settings', App\Http\Controllers\SettingController::class);
    Route::resource('/setting-app', App\Http\Controllers\SettingAppController::class);
    Route::resource('/users', App\Http\Controllers\UserController::class);
    Route::post('/setting-user', [App\Http\Controllers\SettingUserController::class, 'account']);
    Route::post('/report-excel', [App\Http\Controllers\ReportController::class, 'excel']);
    Route::post('/setting-password', [App\Http\Controllers\SettingUserController::class, 'password']);
    Route::post('/report/excel', [App\Http\Controllers\ReportController::class, 'excel']);
    Route::post('/report/pdf', [App\Http\Controllers\ReportController::class, 'pdf']);
    Route::get('/{any}', [App\Http\Controllers\AppController::class, 'index'])->where('any', '.*');
});






Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

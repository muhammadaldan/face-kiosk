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
    Route::get('/{any}', [App\Http\Controllers\AppController::class, 'index'])->where('any', '.*');
});






Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

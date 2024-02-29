<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\InstanceController;
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
Route::resource('/permissions', PermissionsController::class);


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('dashboard', [LoginController::class, 'show_dash'])->name('dashboard.home');
Route::get('instances', [InstanceController::class, 'indexMain'])->name('instances');
Route::get('instanceCreation', [InstanceController::class, 'indexCreation'])->name('instanceCreation');
Route::post('/instancesData', [InstanceController::class, "instancesData"])->name('instancesData');
Route::post('create', [InstanceController::class, 'create'])->name('create');

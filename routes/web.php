<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\InstanceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
    return view('auth.login');
});

Auth::routes();

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::group(["prefix"=>"dashboard",'as'=>"dashboard.",'middleware'=>"auth"],function(){
    Route::get('/', [LoginController::class, 'show_dash'])->name('home');
    Route::get('instances', [InstanceController::class, 'indexMain'])->name('instances');
    Route::get('instanceCreation', [InstanceController::class, 'indexCreation'])->name('instanceCreation');
    Route::post('/instancesData', [InstanceController::class, "instancesData"])->name('instancesData');
    Route::post('create', [InstanceController::class, 'create'])->name('create');
    
});
Route::resource('/permissions', PermissionsController::class);
Route::get('permissions/{permissionId}/delete', [PermissionsController::class, 'destroy']);



Route::resource('/roles', RoleController::class);
Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);
Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);
Route::resource('users',UserController::class);
Route::get('users/{userId}/delete', [UserController::class, 'destroy']);





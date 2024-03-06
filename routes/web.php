<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ElementsController;
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


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::group(["prefix" => "dashboard", 'as' => "dashboard.", 'middleware' => "auth"], function () {
    Route::get('/', [LoginController::class, 'show_dash'])->name('home');
    Route::get('instances', [InstanceController::class, 'indexMain'])->name('instances');
    Route::get('instanceCreation', [InstanceController::class, 'indexCreation'])->name('instanceCreation');
    Route::post('/instancesData', [InstanceController::class, "instancesData"])->name('instancesData');
    Route::post('createinstance', [InstanceController::class, 'create'])->name('createInstance');

    Route::get('elements', [ElementsController::class, 'indexMain'])->name('elements');
    Route::get('elementCreation', [ElementsController::class, 'indexCreation'])->name('elementCreation');
    Route::post('createElement', [ElementsController::class, 'create'])->name('createElement');
    Route::get('edit/{id}', [InstanceController::class, 'edit'])->name('dashboard.edit');
    Route::delete('delete/{id}', [InstanceController::class, 'delete'])->name('dashboard.delete');
    Route::post('/elementsData', [ElementsController::class, "elementsData"])->name('elementsData');

    Route::post('create-instance', [InstanceController::class, 'create'])->name('dashboard.createInstance');
    Route::post('update-instance/{id}', [InstanceController::class, 'update'])->name('dashboard.updateInstance');
});



Route::resource('/permissions', PermissionsController::class);

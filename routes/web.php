<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ElementsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\InstanceController;
use App\Http\Controllers\MappingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Termwind\Components\Element;

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
    Route::post('createinstance', [InstanceController::class, 'create'])->name('createInstance');
    Route::post('/instancesData', [InstanceController::class, "instancesData"])->name('instancesData');

    Route::delete('deleteInstance/{id}', [InstanceController::class, 'deleteInstance'])->name('dashboard.deleteInstance');
    Route::get('editInstance/{id}', [InstanceController::class, 'editInstance'])->name('dashboard.editInstance');



    Route::get('elements', [ElementsController::class, 'indexMain'])->name('elements');
    Route::get('elementCreation', [ElementsController::class, 'indexCreation'])->name('elementCreation');
    Route::post('createElement', [ElementsController::class, 'create'])->name('createElement');
    Route::post('/elementsData', [ElementsController::class, "elementsData"])->name('elementsData');
    Route::get('editElement/{id}', [ElementsController::class, 'editElement'])->name('dashboard.editElement');
    Route::post('update-instance/{id}', [ElementsController::class, 'updateElement'])->name('dashboard.updateElement');
    Route::post('up_instance/{id}', [InstanceController::class, 'update'])->name('updateInstance');
    Route::delete('deleteElement/{id}', [ElementsController::class, 'deleteElement'])->name('dashboard.deleteElement');


    Route::get('requestApiElements/{id}', [ApiController::class, 'IntegrationFunc'])->name('dashboard.requestApiElements');
    Route::get('elementMapping/{id}', [ApiController::class, 'fetchElementsByInstanceId'])->name('dashboard.fetchElementsByInstanceId');
    Route::get('/postMapping', [MappingController::class, 'mappingFunction']);


    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/payrolls-report', [ReportController::class, 'showPayrollsReport'])->name('payrolls-report');
    Route::get('/elements-report', [ReportController::class, 'showElementsReport'])->name('elements-report');
    Route::get('/periods-report', [ReportController::class, 'showPeriodsReport'])->name('periods-report');
    Route::get('/run-values-report', [ReportController::class, 'showRunValuesReport'])->name('run-values-report');




    Route::post('/instances-payrolls-report', [ReportController::class, "instancesPayrollsReport"])->name('instancesPayrollsReport');
    Route::post('/instances-elements-report', [ReportController::class, "instancesElementsReport"])->name('instancesElementsReport');
    Route::post('/instances-periods-report', [ReportController::class, "instancesPeriodsReport"])->name('instancesPeriodsReport');

    Route::post('/instances-run-values-report', [ReportController::class, "instancesRunValuesReport"])->name('instancesRunValuesReport');
});



Route::resource('/permissions', PermissionsController::class);
Route::post('create', [InstanceController::class, 'create'])->name('create');




Route::prefix('')->group(function () {
    Route::resource('/permissions', PermissionsController::class);
    Route::get('permissions/{permissionId}/delete', [PermissionsController::class, 'destroy']);
});



// Route::resource('/permissions', PermissionsController::class);
// Route::get('permissions/{permissionId}/delete', [PermissionsController::class, 'destroy']);



Route::resource('/roles', RoleController::class);
Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);
Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);
Route::resource('users', UserController::class);
Route::get('users/{userId}/delete', [UserController::class, 'destroy']);

Route::get('/auth/redirect', [LoginController::class, 'authGithubRedirect'])->name('auth/redirect');

Route::get('/auth/callback', [LoginController::class, 'authGithubCallback']);

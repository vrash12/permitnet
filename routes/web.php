<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceAccessRequestController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\OrganizationController;

Route::get('/', function () {
    if (session('is_logged_in')) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest.only')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('admin.only')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Organization
    |--------------------------------------------------------------------------
    */

    Route::get('/organization', [OrganizationController::class, 'index'])
        ->name('organization.index');

    Route::get('/organization/members/{member}', [OrganizationController::class, 'show'])
        ->name('organization.show');

    /*
    |--------------------------------------------------------------------------
    | Devices
    |--------------------------------------------------------------------------
    */

    Route::get('/devices', [DeviceController::class, 'index'])
        ->name('devices.index');

    Route::get('/devices/{device}', [DeviceController::class, 'show'])
        ->name('devices.show');

    Route::post('/devices/{device}/block', [DeviceController::class, 'block'])
        ->name('devices.block');

    Route::post('/devices/{device}/unblock', [DeviceController::class, 'unblock'])
        ->name('devices.unblock');

    Route::post('/devices/{device}/role', [DeviceController::class, 'updateRole'])
        ->name('devices.updateRole');

    /*
    |--------------------------------------------------------------------------
    | Access Requests
    |--------------------------------------------------------------------------
    */

    Route::get('/requests', [DeviceAccessRequestController::class, 'index'])
        ->name('requests.index');

    Route::get('/requests/{accessRequest}', [DeviceAccessRequestController::class, 'show'])
        ->name('requests.show');

    Route::post('/requests/{accessRequest}/approve', [DeviceAccessRequestController::class, 'approve'])
        ->name('requests.approve');

    Route::post('/requests/{accessRequest}/deny', [DeviceAccessRequestController::class, 'deny'])
        ->name('requests.deny');

    /*
    |--------------------------------------------------------------------------
    | Logs
    |--------------------------------------------------------------------------
    */
Route::get('/organization', [OrganizationController::class, 'index'])
    ->name('organization.index');

Route::post('/organization/members', [OrganizationController::class, 'store'])
    ->name('organization.store');

Route::get('/organization/members/{member}', [OrganizationController::class, 'show'])
    ->name('organization.show');

Route::put('/organization/members/{member}', [OrganizationController::class, 'update'])
    ->name('organization.update');

Route::delete('/organization/members/{member}', [OrganizationController::class, 'destroy'])
    ->name('organization.destroy');
    
    Route::get('/logs', [LogController::class, 'index'])
        ->name('logs.index');

    Route::get('/logs/{log}', [LogController::class, 'show'])
        ->name('logs.show');
});

/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    if (session('is_logged_in')) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});
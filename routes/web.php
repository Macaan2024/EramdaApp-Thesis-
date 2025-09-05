<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BFPController;
use App\Http\Controllers\AdminUserManagementController;
use App\Http\Controllers\AdminBarangayController;
use App\Http\Controllers\AdminIncidentTypesController;
use App\Http\Controllers\AdminEmergencyVehiclesController;
use App\Http\Controllers\AdminAgenciesController;
use App\Http\Controllers\BFPPersonnelRespondersController;

/*
|--------------------------------------------------------------------------
| User Authentication Routes
|--------------------------------------------------------------------------
*/

Route::controller(AuthenticationController::class)->group(function () {
    Route::view('/', 'PAGES/welcome')->name('/');
    Route::get('register', 'register')->name('register');
    Route::post('submit-register', 'submitRegister');
    Route::post('submit-login', 'login');
    Route::post('submit-logout', 'logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| BDRRMC Routes
|--------------------------------------------------------------------------
*/

Route::prefix('bdrrmc')->name('bdrrmc')->group(function () {

    Route::view('dashboard', 'PAGES/BDRRMC/dashboard')->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| BFP Routes
|--------------------------------------------------------------------------
*/

Route::prefix('bfp')->name('bfp.')->group(function () {

    Route::view('dashboard', 'PAGES/BFP/dashboard')->name('dashboard');

    Route::controller(BFPPersonnelRespondersController::class)->group(function () {
        Route::view('dashboard', 'PAGES/BFP/dashboard')->name('dashboard'); 
        Route::get('respondersmanagement', 'index')->name('respondersmanagement'); //done
        Route::get('respondersmanagement/add-responders', 'register')->name('add-responders'); //done
        Route::post('submit-responders', 'addResponders')->name('submit-responders'); //done
        Route::delete('delete-responders/{id}', 'destroy')->name('delete-responders'); //done
        Route::get('respondersmanagement/edit-responders/{id}', 'edit')->name('edit-responders'); //done
        Route::put('respondersmanagement/update-responders/{id}', 'updateResponders')->name('update-responders'); //done
        Route::get('respondersmanagement/search', 'index')->name('search-responders'); //done
        Route::get('respondersmanagement/view-responders/{id}', 'show')->name('view-responders'); //done

    });
});
/*
|--------------------------------------------------------------------------
| Admin Routes (All Nested Under /admin + Route Name Prefix admin.)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // 🔹 Admin Dashboard & User Management
    Route::controller(AdminUserManagementController::class)->group(function () {
        Route::view('dashboard', 'PAGES/admin/dashboard')->name('dashboard');
        Route::get('usermanagement', 'index')->name('usermanagement');
        Route::view('usermanagement/add-user', 'PAGES/admin/add-user')->name('add-user');
        Route::post('submit-user', 'addUser')->name('submit-user');
        Route::delete('delete-user/{id}', 'destroy')->name('delete-user');
        Route::get('usermanagement/edit-user/{id}', 'edit')->name('edit-user');
        Route::put('usermanagement/update-user/{id}', 'updateUser')->name('update-user');
        Route::get('usermanagement/search', 'index')->name('search-user');
    });

    // 🔹 Admin Barangay Management
    Route::controller(AdminBarangayController::class)->group(function () {
        Route::get('manage-barangay', 'index')->name('manage-barangay');
        Route::view('manage-barangay/add', 'PAGES/admin/add-barangay')->name('add-barangay');
        Route::post('manage-barangay/submit', 'addBarangay')->name('submit-barangay');
        Route::get('manage-barangay/search', 'index')->name('search-barangay');
        Route::delete('manage-barangay/delete/{id}', 'destroy')->name('delete-barangay');
        Route::get('manage-barangay/edit/{id}', 'edit')->name('edit-barangay');
        Route::put('manage-barangay/update/{id}', 'updateBarangay')->name('update-barangay');
    });

    // 🔹 Admin Incident Types Management
    Route::controller(AdminIncidentTypesController::class)->group(function () {
        Route::get('manage-incident-types', 'index')->name('manage-incident-types');
        Route::view('manage-incident-types/add', 'PAGES/admin/add-incident-types')->name('add-incident-types');
        Route::post('manage-incident-types/submit', 'addIncidentTypes')->name('submit-incident-types');
        Route::get('manage-incident-types/search', 'index')->name('search-incident-types');
        Route::delete('manage-incident-types/delete/{id}', 'destroy')->name('delete-incident-types');
        Route::get('manage-incident-types/edit/{id}', 'edit')->name('edit-incident-types');
        Route::put('manage-incident-types/update/{id}', 'updateIncidentTypes')->name('update-incident-types');
    });

    // 🔹 Admin Emergency Vehicles Management
    Route::controller(AdminEmergencyVehiclesController::class)->group(function () {
        Route::get('manage-emergency-vehicles', 'index')->name('manage-emergency-vehicles');
        Route::view('manage-emergency-vehicles/add', 'PAGES/admin/add-emergency-vehicles')->name('add-emergency-vehicles');
        Route::post('manage-emergency-vehicles/submit', 'addEmergencyVehicles')->name('submit-emergency-vehicles');
        Route::get('manage-emergency-vehicles/search', 'index')->name('search-emergency-vehicles');
        Route::delete('manage-emergency-vehicles/delete/{id}', 'destroy')->name('delete-emergency-vehicles');
        Route::get('manage-emergency-vehicles/edit/{id}', 'edit')->name('edit-emergency-vehicles');
        Route::put('manage-emergency-vehicles/update/{id}', 'updateEmergencyVehicles')->name('update-emergency-vehicles');
    });

    // 🔹 Admin Agencies Management
    Route::controller(AdminAgenciesController::class)->group(function () {
        Route::get('manage-agencies', 'index')->name('manage-agencies');
        Route::get('manage-agencies/add', 'displayBarangay')->name('add-agencies');
        Route::post('manage-agencies/submit', 'addAgencies')->name('submit-agencies');
        Route::get('manage-agencies/search', 'index')->name('search-agencies');
        Route::delete('manage-agencies/delete/{id}', 'destroy')->name('delete-agencies');
        Route::get('manage-agencies/edit/{id}', 'edit')->name('edit-agencies');
        Route::put('manage-agencies/update/{id}', 'updateAgencies')->name('update-agencies');
    });
});

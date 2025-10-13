<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\EmergencyVehiclesController;
use App\Http\Controllers\IncidentReportsController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\PersonnelRespondersController;
use App\Http\Controllers\UserController;


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




Route::controller(DashboardsController::class)->group(function () {
    Route::get('bfp/dashboard', 'bfp')->name('bfp.dashboard');
    Route::get('bdrrmc/dashboard', 'bdrrmc')->name('bdrrmc.dashboard');
    Route::get('admin/dashboard', 'admin')->name('admin.dashboard');
    Route::get('hospital/dashboard', 'admin')->name('hospital.dashboard');
});



Route::prefix('bfp')->name('bfp.')->group(function () {

    Route::controller(PersonnelRespondersController::class)->group(function () {
        Route::get('responders', 'index')->name('responders');
        Route::get('add-responder', 'register')->name('add-responders'); //done
        Route::post('submit-responder', 'addResponders')->name('submit-responders'); //done
        Route::delete('delete-responder/{id}', 'destroy')->name('delete-responders'); //done
        Route::get('edit-responder/{id}', 'edit')->name('edit-responders'); //done
        Route::put('update-responder/{id}', 'updateResponders')->name('update-responders'); //done
        Route::get('search', 'index')->name('search-responders'); //done
        Route::get('view-responders/{id}', 'show')->name('view-responders'); //done
    });

    Route::controller(EmergencyVehiclesController::class)->group(function () {
        Route::get('vehicles', 'index')->name('vehicles'); //done
        Route::view('vehicles/add-vehicles', 'PAGES/BFP_BDRRMC/add-vehicles')->name('add-vehicles'); //done
        Route::post('submit-vehicles', 'addVehicles')->name('submit-vehicles'); //done
        Route::delete('delete-vehicles/{id}', 'destroy')->name('delete-vehicles'); //done
        Route::get('vehicles/edit-responders/{id}', 'edit')->name('edit-vehicles'); //done
        Route::put('vehicles/update-responders/{id}', 'updateVehicles')->name('update-vehicles'); //done
        Route::get('vehicles/search', 'index')->name('search-vehicles'); //done
        Route::get('vehicles/view-vehicles/{id}', 'show')->name('view-vehicles'); //done
    });



    Route::controller(IncidentReportsController::class)->group(function () {
        Route::get('reports', 'submittedReports')->name('submitted-reports'); //done
        Route::get('requests', 'requestReports')->name('request-reports'); //done
        Route::get('receive', 'receiveReports')->name('receive-reports'); //done
        Route::get('reports/add/{types}', 'create')->name('create-reports'); //done
        Route::post('submit-reports', 'addReports')->name('submit-reports'); //done

        Route::get('search-submitted-reports', 'submittedReports')->name('search-submitted-reports'); //done
        Route::get('search-request-reports', 'requestReports')->name('search-request-reports'); //done
        Route::get('search-receive-reports', 'receiveReports')->name('search-receive-reports'); //done





        // Route::view('reports/add-reports', 'PAGES/BFP/add-reports')->name('add-reports'); //done
        // Route::post('submit-reports', 'addReports')->name('submit-reports'); //done
        // Route::delete('delete-reports/{id}', 'destroy')->name('delete-reports'); //done
        // Route::get('reports/edit-reports/{id}', 'edit')->name('edit-reports'); //done
        // Route::put('reports/update-reports/{id}', 'updateReports')->name('update-reports'); //done
        // Route::get('reports/search', 'index')->name('search-reports'); //done
        // Route::get('reports/view-reports/{id}', 'show')->name('view-reports'); //done
    });
});

Route::prefix('admin')->name('admin.')->group(function () {

    // 🔹 Admin Agencies Management
    Route::controller(AgencyController::class)->group(function () {
        Route::get('agency', 'index')->name('agency');
        Route::get('add-agency', 'displayBarangay')->name('add-agency');
        Route::post('submit-agency', 'addAgency')->name('submit-agency');
        Route::get('search-agency', 'index')->name('search-agency');
        Route::delete('delete-agency/{id}', 'destroy')->name('delete-agency');
        Route::get('edit-agency/{id}', 'edit')->name('edit-agency');
        Route::put('update-agency/{id}', 'updateAgencies')->name('update-agency');
    });

    Route::controller(LogsController::class)->group(function () {
        //manage logs
        Route::get('logs/{status}', 'index')->name('logs');

        // User logs
        Route::get('logs-users/{status}/{id?}', 'userLogs')->name('logs-users');
        Route::get('logs-view-users/{id}', 'showUser')->name('logs-view-users');
        Route::get('logs-users-add', 'usersAdd')->name('logs-users-add'); // Add user page
        Route::post('logs-add-users', 'addUsers')->name('logs-add-users'); // Store user
        Route::get('logs-edit-users/{id}', 'editUser')->name('logs-edit-users');
        Route::put('logs-update-users/{id}', 'updateUser')->name('logs-update-users');
        Route::delete('logs-delete-users/{id}', 'destroyUser')->name('logs-delete-users');
        Route::put('logs-restore-users/{id}', 'restoreUser')->name('logs-restore-users');


        // Vehicles log Controller

        Route::get('logs-vehicles/{status}/{id?}', 'vehicleLogs')->name('logs-vehicles');
        Route::get('logs-view-vehicles/{id}', 'showVehicle')->name('logs-view-vehicles');
        Route::get('logs-vehicles-add', 'vehiclesAdd')->name('logs-vehicles-add');
        Route::post('logs-add-vehicles', 'addVehicles')->name('logs-add-vehicles');
        Route::get('logs-edit-vehicles/{id}', 'edit')->name('logs-edit-vehicles');
        Route::put('logs-update-vehicles/{id}', 'updateVehicles')->name('logs-update-vehicles');
        Route::delete('logs-delete-vehicles/{id}', 'destroyVehicle')->name('logs-delete-vehicles');
        Route::put('logs-restore-vehicles/{id}', 'restoreVehicle')->name('logs-restore-vehicles');
    });
});

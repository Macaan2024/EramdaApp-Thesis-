<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AdminUserManagementController;
use App\Http\Controllers\AdminBarangayController;
use App\Http\Controllers\AdminIncidentTypesController;
use App\Http\Controllers\AdminEmergencyVehiclesController;
use App\Http\Controllers\AdminAgenciesController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\EmergencyVehiclesController;
use App\Http\Controllers\IncidentReportsController;
use App\Http\Controllers\IncidentTypesController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\PersonnelRespondersController;
use App\Http\Controllers\UserController;
use App\Models\Barangay;

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
    Route::controller(BarangayController::class)->group(function () {
        Route::get('barangay', 'index')->name('barangay');
        Route::view('add-barangay', 'PAGES/admin/add-barangay')->name('add-barangay');
        Route::post('submit-barangay', 'addBarangay')->name('submit-barangay');
        Route::get('search-barangay', 'index')->name('search-barangay');
        Route::delete('delete-barangay/{id}', 'destroy')->name('delete-barangay');
        Route::get('edit-barangay/{id}', 'edit')->name('edit-barangay');
        Route::put('update-barangay/{id}', 'updateBarangay')->name('update-barangay');
        Route::get('view-barangay/{id}', 'show')->name('view-barangay');
    });

    // 🔹 Admin Incident Types Management
    Route::controller(IncidentTypesController::class)->group(function () {
        Route::get('incident-types', 'index')->name('incident-types');
        Route::view('add', 'PAGES/admin/add-incident-types')->name('add-incident-types');
        Route::post('submit', 'addIncidentTypes')->name('submit-incident-types');
        Route::get('search', 'index')->name('search-incident-types');
        Route::delete('delete/{id}', 'destroy')->name('delete-incident-types');
        Route::get('edit/{id}', 'edit')->name('edit-incident-types');
        Route::put('update/{id}', 'updateIncidentTypes')->name('update-incident-types');
    });

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
        Route::get('logs/user/{status}', 'index')->name('logs.user');


        // Responder log Controller
        Route::get('logs-responder/{status}/{agency?}', 'responderIndex')->name('logs-responder');
        Route::get('logs-filter-agency/{status}', 'responderIndex')->name('logs-filter-agency');
        Route::get('logs-search-responders', 'responderIndex')->name('logs-search-responders');
        Route::get('logs-track/{user}/{id}', 'trackResponder')->name('logs-track');

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

    Route::controller(UserController::class)->group(function () {
        Route::get('responders/{status}', 'index')->name('responders');
        Route::get('add-responders', 'register')->name('add-responders');
        ROute::get('view-responder/{id}', 'show')->name('view-responder');
        Route::get('edit-responders/{id}', 'edit')->name('edit-responders');
        Route::put('update-responders/{id}', 'updateResponders')->name('update-responders');
        Route::patch('responders/{id}/restore', 'restore')->name('restore-responders');
        Route::delete('responders/{id}/force-delete', 'forceDelete')->name('force-delete-responders');
        Route::patch('responders/{id}/accept', 'accept')->name('accept-responders');
        Route::patch('responders/{id}/decline', 'decline')->name('decline-responders');
        Route::get('search-responders', 'index')->name('search-responders');
        Route::get('filter-agency/{status}', 'index')->name('filter-agency');
        Route::get('filter-responders/{status}', 'index')->name('filter-responders');
    });
});


// Route::prefix('bfp')->name('bfp.')->group(function () {

//     Route::controller(DashboardsController::class)->group(function () {
//         Route::view('dashboard', 'dashboard')->name('dashboard');
//     });
// });

// Route::prefix('bfp')->name('bfp.')->group(function () {

//     Route::view('dashboard', 'PAGES/BFP/dashboard')->name('dashboard');

//     Route::controller(BFPPersonnelRespondersController::class)->group(function () {
//         Route::view('dashboard', 'PAGES/BFP/dashboard')->name('dashboard');
//         Route::get('respondersmanagement', 'index')->name('respondersmanagement'); //done
//         Route::get('respondersmanagement/add-responders', 'register')->name('add-responders'); //done
//         Route::post('submit-responders', 'addResponders')->name('submit-responders'); //done
//         Route::delete('delete-responders/{id}', 'destroy')->name('delete-responders'); //done
//         Route::get('respondersmanagement/edit-responders/{id}', 'edit')->name('edit-responders'); //done
//         Route::put('respondersmanagement/update-responders/{id}', 'updateResponders')->name('update-responders'); //done
//         Route::get('respondersmanagement/search', 'index')->name('search-responders'); //done
//         Route::get('respondersmanagement/view-responders/{id}', 'show')->name('view-responders'); //done

//     });


//     Route::controller(BFPEmergencyVehiclesController::class)->group(function () {
//         Route::view('dashboard', 'PAGES/BFP/dashboard')->name('dashboard');
//         Route::get('vehicles', 'index')->name('vehicles'); //done
//         Route::view('vehicles/add-vehicles', 'PAGES/BFP/add-vehicles')->name('add-vehicles'); //done
//         Route::post('submit-vehicles', 'addVehicles')->name('submit-vehicles'); //done
//         Route::delete('delete-vehicles/{id}', 'destroy')->name('delete-vehicles'); //done
//         Route::get('vehicles/edit-responders/{id}', 'edit')->name('edit-vehicles'); //done
//         Route::put('vehicles/update-responders/{id}', 'updateVehicles')->name('update-vehicles'); //done
//         Route::get('vehicles/search', 'index')->name('search-vehicles'); //done
//         Route::get('vehicles/view-vehicles/{id}', 'show')->name('view-vehicles'); //done

//     });

//     Route::controller(BFPIncidentReportsController::class)->group(function () {
//         Route::view('dashboard', 'PAGES/BFP/dashboard')->name('dashboard');
//         Route::get('reports', 'index')->name('reports'); //done
//         Route::view('reports/add-reports', 'PAGES/BFP/add-reports')->name('add-reports'); //done
//         Route::post('submit-reports', 'addReports')->name('submit-reports'); //done
//         Route::delete('delete-reports/{id}', 'destroy')->name('delete-reports'); //done
//         Route::get('reports/edit-reports/{id}', 'edit')->name('edit-reports'); //done
//         Route::put('reports/update-reports/{id}', 'updateReports')->name('update-reports'); //done
//         Route::get('reports/search', 'index')->name('search-reports'); //done
//         Route::get('reports/view-reports/{id}', 'show')->name('view-reports'); //done
//     });
// });
/*
|--------------------------------------------------------------------------
| Admin Routes (All Nested Under /admin + Route Name Prefix admin.)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // // 🔹 Admin Dashboard & User Management
    // Route::controller(AdminUserManagementController::class)->group(function () {
    //     Route::view('dashboard', 'PAGES/admin/dashboard')->name('dashboard');
    //     Route::get('usermanagement', 'index')->name('usermanagement');
    //     Route::view('usermanagement/add-user', 'PAGES/admin/add-user')->name('add-user');
    //     Route::post('submit-user', 'addUser')->name('submit-user');
    //     Route::delete('delete-user/{id}', 'destroy')->name('delete-user');
    //     Route::get('usermanagement/edit-user/{id}', 'edit')->name('edit-user');
    //     Route::put('usermanagement/update-user/{id}', 'updateUser')->name('update-user');
    //     Route::get('usermanagement/search', 'index')->name('search-user');
    // });

    // // 🔹 Admin Barangay Management
    // Route::controller(AdminBarangayController::class)->group(function () {
    //     Route::get('manage-barangay', 'index')->name('manage-barangay');
    //     Route::view('manage-barangay/add', 'PAGES/admin/add-barangay')->name('add-barangay');
    //     Route::post('manage-barangay/submit', 'addBarangay')->name('submit-barangay');
    //     Route::get('manage-barangay/search', 'index')->name('search-barangay');
    //     Route::delete('manage-barangay/delete/{id}', 'destroy')->name('delete-barangay');
    //     Route::get('manage-barangay/edit/{id}', 'edit')->name('edit-barangay');
    //     Route::put('manage-barangay/update/{id}', 'updateBarangay')->name('update-barangay');
    // });

    // // 🔹 Admin Incident Types Management
    // Route::controller(AdminIncidentTypesController::class)->group(function () {
    //     Route::get('manage-incident-types', 'index')->name('manage-incident-types');
    //     Route::view('manage-incident-types/add', 'PAGES/admin/add-incident-types')->name('add-incident-types');
    //     Route::post('manage-incident-types/submit', 'addIncidentTypes')->name('submit-incident-types');
    //     Route::get('manage-incident-types/search', 'index')->name('search-incident-types');
    //     Route::delete('manage-incident-types/delete/{id}', 'destroy')->name('delete-incident-types');
    //     Route::get('manage-incident-types/edit/{id}', 'edit')->name('edit-incident-types');
    //     Route::put('manage-incident-types/update/{id}', 'updateIncidentTypes')->name('update-incident-types');
    // });

    // // 🔹 Admin Emergency Vehicles Management
    // Route::controller(AdminEmergencyVehiclesController::class)->group(function () {
    //     Route::get('manage-emergency-vehicles', 'index')->name('manage-emergency-vehicles');
    //     Route::view('manage-emergency-vehicles/add', 'PAGES/admin/add-emergency-vehicles')->name('add-emergency-vehicles');
    //     Route::post('manage-emergency-vehicles/submit', 'addEmergencyVehicles')->name('submit-emergency-vehicles');
    //     Route::get('manage-emergency-vehicles/search', 'index')->name('search-emergency-vehicles');
    //     Route::delete('manage-emergency-vehicles/delete/{id}', 'destroy')->name('delete-emergency-vehicles');
    //     Route::get('manage-emergency-vehicles/edit/{id}', 'edit')->name('edit-emergency-vehicles');
    //     Route::put('manage-emergency-vehicles/update/{id}', 'updateEmergencyVehicles')->name('update-emergency-vehicles');
    // });

    // // 🔹 Admin Agencies Management
    // Route::controller(AdminAgenciesController::class)->group(function () {
    //     Route::get('manage-agencies', 'index')->name('manage-agencies');
    //     Route::get('manage-agencies/add', 'displayBarangay')->name('add-agencies');
    //     Route::post('manage-agencies/submit', 'addAgencies')->name('submit-agencies');
    //     Route::get('manage-agencies/search', 'index')->name('search-agencies');
    //     Route::delete('manage-agencies/delete/{id}', 'destroy')->name('delete-agencies');
    //     Route::get('manage-agencies/edit/{id}', 'edit')->name('edit-agencies');
    //     Route::put('manage-agencies/update/{id}', 'updateAgencies')->name('update-agencies');
    // });
});

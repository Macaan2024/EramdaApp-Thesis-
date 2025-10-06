<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\EmergencyVehicle;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;

class LogsController extends Controller
{



    public function vehicleLogs(Request $request, $status, $id = null)
    {
        $agencies = Agency::all();
        $search = $request->input('search');
        $trackVehicleId = $request->get('track_vehicle_id'); // Detect tracking request

        // =========================
        // VEHICLES PAGINATION LOGIC
        // =========================
        $perPage = 10;
        $vehiclesQuery = EmergencyVehicle::orderBy('id');

        $page = 1; // default page
        if ($trackVehicleId) {
            $allVehicles = $vehiclesQuery->get();
            $position = $allVehicles->search(fn($v) => $v->id == $trackVehicleId);
            if ($position !== false) {
                $page = floor($position / $perPage) + 1;
            }
        }

        $vehicles = $vehiclesQuery->paginate($perPage, ['*'], 'vehicles_page', $page);

        // =========================
        // LOGS QUERY LOGIC (unchanged)
        // =========================
        if (empty($id)) {

            if ($status === 'All') {
                $logsQuery = Log::with(['emergencyVehicle' => function ($query) {
                    $query->withTrashed();
                }])
                    ->whereNotNull('emergency_vehicle_id')
                    ->when($search, function ($query, $search) {
                        $query->whereHas('emergencyVehicle', function ($q) use ($search) {
                            $q->withTrashed()
                                ->where('plateNumber', 'like', "%{$search}%");
                        });
                    });
            } elseif ($status === 'Delete') {
                $logsQuery = Log::with(['emergencyVehicle' => function ($query) {
                    $query->onlyTrashed();
                }])
                    ->whereNotNull('emergency_vehicle_id')
                    ->where('interaction_type', 'Delete')
                    ->when($search, function ($query, $search) {
                        $query->whereHas('emergencyVehicle', function ($q) use ($search) {
                            $q->onlyTrashed()
                                ->where('plateNumber', 'like', "%{$search}%");
                        });
                    });
            } elseif ($status === 'Restore') {
                $logsQuery = Log::onlyTrashed();
            } else {
                $logsQuery = Log::with(['emergencyVehicle' => function ($query) {
                    $query->withTrashed();
                }])
                    ->whereNotNull('emergency_vehicle_id')
                    ->where('interaction_type', $status);
            }
        } else {

            // Check if the agency exists
            $checkAgency = Agency::findOrFail($id);

            if ($checkAgency) {
                if ($status === 'All') {
                    $logsQuery = Log::with(['emergencyVehicle' => function ($query) use ($id) {
                        $query->withTrashed();
                    }])
                        ->where('agency_id', $id)
                        ->whereNotNull('emergency_vehicle_id')
                        ->when($search, function ($query, $search) {
                            $query->whereHas('emergencyVehicle', function ($q) use ($search) {
                                $q->withTrashed()
                                    ->where('plateNumber', 'like', "%{$search}%");
                            });
                        });
                } elseif ($status === 'Delete') {
                    $logsQuery = Log::with(['emergencyVehicle' => function ($query) use ($id) {
                        $query->onlyTrashed();
                    }])
                        ->whereNotNull('emergency_vehicle_id')
                        ->where('interaction_type', 'Delete')
                        ->where('agency_id', $id)
                        ->when($search, function ($query, $search) {
                            $query->whereHas('emergencyVehicle', function ($q) use ($search) {
                                $q->onlyTrashed()
                                    ->where('plateNumber', 'like', "%{$search}%");
                            });
                        });
                } elseif ($status === 'Restore') {
                    $logsQuery = Log::onlyTrashed()->where('agency_id', $id);
                } else {
                    $logsQuery = Log::with(['emergencyVehicle' => function ($query) use ($id) {
                        $query->withTrashed()->where('agency_id', $id);
                    }])
                        ->whereNotNull('emergency_vehicle_id')
                        ->where('interaction_type', $status)
                        ->where('agency_id', $id)
                        ->when($search, function ($query, $search) {
                            $query->whereHas('emergencyVehicle', function ($q) use ($search) {
                                $q->withTrashed()
                                    ->where('plateNumber', 'like', "%{$search}%");
                            });
                        });
                }
            } else {
                return redirect()->back()->with('errors', 'Agency can’t be found');
            }
        }

        // =========================
        // LOGS PAGINATION
        // =========================
        $logs = $logsQuery->orderBy('created_at', 'desc')->paginate(10, ['*'], 'logs_page');

        // =========================
        // VIEW RETURN
        // =========================
        return view('PAGES.admin.logs-vehicle', compact(
            'status',
            'agencies',
            'logs',
            'id',
            'search',
            'vehicles'
        ));
    }




    public function showVehicle($id)
    {
        $log = Log::with('emergencyVehicle')->findOrFail($id);

        if ($log->emergencyVehicle) {
            return view('PAGES.admin.logs-view-vehicle', compact('log'));
        } else {
            return redirect()->back()->with('error', 'No emergency vehicle found for this log.');
        }
    }

    public function vehiclesAdd()
    {

        $agencies = Agency::all();

        return view('PAGES/admin/logs-add-vehicle', compact('agencies'));
    }

    public function addVehicles(Request $request)
    {
        $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'vehicleTypes' => 'required|string|max:255',
            'plateNumber' => 'required|string|max:255|unique:emergency_vehicles,plateNumber',
            'vehicle_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'availabilityStatus' => 'required|in:Available,Unavailable',
        ]);

        $photoPath = $request->hasFile('vehicle_photo')
            ? $request->file('vehicle_photo')->store('vehicles', 'public')
            : null;

        $vehicle = EmergencyVehicle::create([
            'agency_id' => $request->agency_id,
            'vehicleTypes' => $request->vehicleTypes,
            'plateNumber' => $request->plateNumber,
            'vehicle_photo' => $photoPath,
            'availabilityStatus' => $request->availabilityStatus,
        ]);

        if ($vehicle) {

            Log::create([
                'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
                'interaction_type' => 'Add',
                'agency_id' => auth()->user()->agency_id,
                'emergency_vehicle_id' => $vehicle->id, // ✅ only the ID
            ]);

            return redirect()->route('admin.logs-vehicles', 'All')->with('s.uccess', 'Successfully added vehicles');
        } else {
            return redirect()->back()->with('error', 'Fail to add vehicles');
        }
    }

    public function edit($id)
    {

        $vehicles = EmergencyVehicle::findOrFail($id);

        $agencies = Agency::all();

        if ($vehicles) {
            return view('PAGES/admin/logs-edit-vehicle', compact('vehicles', 'agencies'));
        } else {
            return redirect()->back()->with('error', 'Vehicle ID cant be found');
        }
    }


    public function updateVehicles(Request $request, $id)
    {
        $vehicle = EmergencyVehicle::findOrFail($id);

        $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'vehicleTypes' => 'required|string|max:255',
            'plateNumber' => 'required|string|max:255|unique:emergency_vehicles,plateNumber,' . $id,
            'vehicle_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'availabilityStatus' => 'required|in:Available,Unavailable',
        ]);

        // ✅ Define $data before using it
        $data = [
            'agency_id' => $request->agency_id,
            'vehicleTypes' => $request->vehicleTypes,
            'plateNumber' => $request->plateNumber,
            'availabilityStatus' => $request->availabilityStatus,
        ];

        // ✅ Handle photo upload (optional)
        if ($request->hasFile('vehicle_photo')) {
            $data['vehicle_photo'] = $request->file('vehicle_photo')->store('vehicles', 'public');
        }

        // ✅ Update record
        $updated = $vehicle->update($data);

        // ✅ Log the update action
        if ($updated) {
            Log::create([
                'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
                'interaction_type' => 'Update',
                'agency_id' => auth()->user()->agency_id,
                'emergency_vehicle_id' => $vehicle->id,
            ]);

            return redirect()
                ->route('admin.logs-vehicles', ['status' => 'All'])
                ->with('success', 'Successfully updated emergency vehicle.');
        }

        return redirect()
            ->back()
            ->with('error', 'Update failed, please try again.')
            ->withInput();
    }

    public function destroyVehicle($id)
    {

        $vehicle = EmergencyVehicle::findOrFail($id);

        $vehicle->delete();

        if ($vehicle) {
            // ✅ Delete all logs related to this vehicle (if needed)
            Log::where('emergency_vehicle_id', $id)->delete();

            // Log action before delete
            Log::create([
                'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
                'interaction_type' => 'Delete',
                'agency_id' => auth()->user()->agency_id,
                'emergency_vehicle_id' => $vehicle->id
            ]);

            return redirect()->route('admin.logs-vehicles', ['status' => 'All'])->with('success', 'Emergency Vehicle successfully deleted.');
        } else {
            return redirect()->back()->with('error', 'Delete failed, please try again.');
        }
    }

    public function deleteLogVehicles($id)
    {

        $vehicle = Log::findOrFail($id)->delete();

        return $vehicle ? redirect()->back()->with('success', 'Successfully deleted vehicle log') : redirect()->back()->with('error', 'Fail to delete vehicle log');
    }

    public function restoreVehicle($id)
    {
        // Find the soft-deleted vehicle
        $vehicle = EmergencyVehicle::onlyTrashed()->find($id);

        if (!$vehicle) {
            return redirect()->back()->with('error', 'Vehicle not found or already restored.');
        }
        // Restore the vehicle
        $vehicle->restore();

        if ($vehicle) {
            // Log the restore action
            Log::create([
                'interaction_type' => 'Restore',
                'agency_id' => auth()->user()->agency_id,
                'emergency_vehicle_id' => $vehicle->id,
            ]);
            return redirect()->back()->with('success', 'Emergency Vehicle successfully restored.');
        } else {
            return redirect()->back()->with('error', 'Vehicle cant be restore');
        }
    }




    public function responderIndex(Request $request, $status)
    {
        $agencies = Agency::all();
        $selectedAgency = $request->agency ?? '';

        // Logs with filters
        $logs = Log::with('user')
            ->whereNotNull('user_id')
            ->whereHas('user', function ($query) {
                $query->where('user_type', 'responders');
            })
            ->when($selectedAgency, function ($query) use ($selectedAgency) {
                $query->whereHas('user', function ($q) use ($selectedAgency) {
                    $q->where('agency_id', $selectedAgency);
                });
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('interaction_type', 'like', '%' . $request->search . '%')
                        ->orWhereHas('user', function ($userQ) use ($request) {
                            $userQ->where('firstname', 'like', '%' . $request->search . '%')
                                ->orWhere('lastname', 'like', '%' . $request->search . '%');
                        });
                });
            })
            ->when($status !== 'All', function ($query) use ($status) {
                $query->where('interaction_type', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // === Simple readable counts ===
        if ($selectedAgency) {
            $addCount = Log::where('interaction_type', 'Add Responder')
                ->whereHas('user', fn($q) => $q->where('agency_id', $selectedAgency))
                ->count();

            $editCount = Log::where('interaction_type', 'Update Responder')
                ->whereHas('user', fn($q) => $q->where('agency_id', $selectedAgency))
                ->count();

            $deleteCount = Log::where('interaction_type', 'Delete Responder')
                ->whereHas('user', fn($q) => $q->where('agency_id', $selectedAgency))
                ->count();

            $totalCount = Log::whereHas('user', fn($q) => $q->where('agency_id', $selectedAgency))
                ->count();
        } else {
            $addCount = Log::where('interaction_type', 'Add Responder')->count();
            $editCount = Log::where('interaction_type', 'Update Responder')->count();
            $deleteCount = Log::where('interaction_type', 'Delete Responder')->count();
            $totalCount = Log::count();
        }

        return view('PAGES.admin.user-logs', compact(
            'logs',
            'agencies',
            'status',
            'selectedAgency',
            'addCount',
            'editCount',
            'deleteCount',
            'totalCount'
        ));
    }




    public function trackResponder(User $user, $id)
    {

        // Paginate logs for this user
        $logs = Log::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10); // adjust page size

        return view('PAGES/admin/track-user', compact('user', 'logs', 'id'));
    }



    public function index($status, $id = null)
    {
        $vehicles = EmergencyVehicle::withTrashed()->paginate(10);

        $users = User::withTrashed()

            ->paginate(10);
        return view('PAGES.admin.manage-logs', compact('vehicles', 'users', 'status'));
    }
}

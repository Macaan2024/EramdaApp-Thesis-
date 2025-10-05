<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\EmergencyVehicle;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;

class LogsController extends Controller
{

    public function vehicleIndex(Request $request, $status, $id = null)
    {
        $agencies = Agency::all();
        $search = $request->input('search');

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
                return redirect()->back()->with('errors', 'Agency cant be found');
            }
        }

        $logs = $logsQuery->orderBy('created_at', 'desc')->paginate(10);

        return view('PAGES.admin.logs-vehicle', compact('status', 'agencies', 'logs', 'id', 'search'));
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



    public function index()
    {

        return view('PAGES/admin/manage-logs');
    }
}

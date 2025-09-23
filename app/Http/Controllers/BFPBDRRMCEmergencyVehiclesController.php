<?php

namespace App\Http\Controllers;


use App\Models\EmergencyVehicle;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BFPBDRRMCEmergencyVehiclesController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = EmergencyVehicle::when($request->search, function ($query) use ($request) {
            return $query->whereAny([
                'vehicleTypes',
                'plateNumber',
            ], 'like', '%'  . $request->search . '%');
        })->paginate(10);

        return view('PAGES/BFP/manage-vehicles', compact('vehicles'));
    }
    
    public function addVehicles(Request $request)
    {
        $request->validate([
            'agency_id'       => 'required|exists:agencies,id',
            'vehicleTypes'       => 'required|string|max:100',
            'plateNumber'        => 'required|string|unique:emergency_vehicles,plateNumber|max:20',
            'vehicle_photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'availabilityStatus' => 'required|in:Available,Unavailable,In Maintenance',
        ]);

        $vehiclePhoto = null;
        if ($request->hasFile('vehicle_photo')) {
            $vehiclePhoto = $request->file('vehicle_photo')->store('photos', 'public');
        }

        $vehicles = EmergencyVehicle::create([
            'agency_id'          => $request->agency_id,
            'vehicleTypes'       => $request->vehicleTypes,
            'plateNumber'        => $request->plateNumber,
            'vehicle_photo'      => $vehiclePhoto,
            'availabilityStatus' => $request->availabilityStatus
        ]);

        if ($vehicles) {
            // ✅ Log vehicle creation
            Log::create([
                'interaction_type' => 'Add Vehicle',
                'user_id' => Auth::id(),
                'agency_id' => Auth::user()->agency_id ?? null,
                'emergency_vehicle_id' => $vehicles->id,
            ]);

            return redirect()->route('bfp.vehicles')
                ->with('success', 'Successfully registered vehicle.');
        } else {
            return redirect()->back()->with('error', 'Failed to register vehicle.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $vehicles = EmergencyVehicle::findOrFail($id);

        return view('PAGES/BFP/edit-vehicles', compact('vehicles'));
    }

    /**
     * Update the specified emergency vehicle.
     */
    public function updateVehicles(Request $request, $id)
    {
        $vehicles = EmergencyVehicle::findOrFail($id);

        $request->validate([
            'vehicleTypes'       => 'required|string|max:100',
            'plateNumber'        => 'required|string|max:20|unique:emergency_vehicles,plateNumber,' . $id,
            'vehicle_photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'availabilityStatus' => 'required|in:Available,Unavailable,In Maintenance',
        ]);

        $data = [
            'vehicleTypes'       => $request->vehicleTypes,
            'plateNumber'        => $request->plateNumber,
            'availabilityStatus' => $request->availabilityStatus,
        ];

        if ($request->hasFile('vehicle_photo')) {
            $data['vehicle_photo'] = $request->file('vehicle_photo')->store('photos', 'public');
        }

        $updated = $vehicles->update($data);

        if ($updated) {
            // ✅ Log vehicle update
            Log::create([
                'interaction_type' => 'Update Vehicle',
                'user_id' => Auth::id(),
                'agency_id' => Auth::user()->agency_id ?? null,
                'emergency_vehicle_id' => $vehicles->id,
            ]);
        }

        return $updated
            ? redirect()->route('bfp.vehicles')->with('success', 'Successfully updated emergency vehicle.')
            : redirect()->back()
            ->withErrors(['error' => 'Update failed, please try again.'])
            ->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vehicles = EmergencyVehicle::findOrFail($id);

        // ✅ Log before delete
        Log::create([
            'interaction_type' => 'Delete Vehicle',
            'user_id' => Auth::id(),
            'agency_id' => Auth::user()->agency_id ?? null,
            'emergency_vehicle_id' => $vehicles->id,
        ]);

        $vehicles->delete();

        if ($vehicles) {
            return redirect()->back()->with('success', 'Successfully deleted vehicle.');
        } else {
            return redirect()->back()
                ->with('error', 'Delete Fail, please try again.');
        }
    }

    public function show($id)
    {
        $vehicles = EmergencyVehicle::find($id);

        if ($vehicles) {
            return view('PAGES/BFP/view-vehicles', compact('vehicles'));
        } else {
            return redirect()->back()
                ->with('error', $vehicles->vehicleTypes . ' can\'t be found');
        }
    }
}

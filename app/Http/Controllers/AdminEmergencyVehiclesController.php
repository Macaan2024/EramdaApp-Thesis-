<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyVehicle;

class AdminEmergencyVehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $emergencyVehicles = EmergencyVehicle::when($request->search, function ($query) use ($request) {
            return $query->whereAny([
                'vehicleTypes',
                'plateNumber',
                'vehicle_photo',
                'availabilityStatus',
            ], 'like', '%'  . $request->search . '%');
        })->paginate(10);

        return view('PAGES/admin/manage-emergency-vehicles', compact('emergencyVehicles'));
    }

    public function addEmergencyVehicles(Request $request)
    {
        $request->validate([
            'vehicleTypes'       => 'required|string|max:100',
            'plateNumber'        => 'required|string|unique:emergency_vehicles,plateNumber|max:20',
            'vehicle_photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'availabilityStatus' => 'required|in:Available,Unavailable,In Maintenance',
        ]);

        $vehiclePhoto = null;
        if ($request->hasFile('vehicle_photo')) {
            $vehiclePhoto = $request->file('vehicle_photo')->store('photos', 'public');
        }

        $emergencyVehicles = EmergencyVehicle::create([
            'vehicleTypes'       => $request->vehicleTypes,
            'plateNumber'        => $request->plateNumber,
            'vehicle_photo'      => $vehiclePhoto,
            'availabilityStatus' => $request->availabilityStatus
        ]);

        if ($emergencyVehicles) {
            return redirect()->route('manage-emergency-vehicles.admin')->with('success', 'Successfully Register Vehicles');
        } else {
            return redirect()->back()->with('error', 'Failed to Register Vehicles');
        }
    }


    public function edit($id)
    {
        $emergencyVehicles = EmergencyVehicle::findOrFail($id);



        return view('PAGES/admin/edit-emergency-vehicles', compact('emergencyVehicles'));
    }

    public function updateEmergencyVehicles(Request $request, $id)
    {
        $emergencyVehicles = EmergencyVehicle::findOrFail($id);

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

        $emergencyVehicles->update($data);

        return redirect()->route('manage-emergency-vehicles.admin')
            ->with('success', 'Successfully Modification Vehicle');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $emergencyVehicles = EmergencyVehicle::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Successfully Delete Vehicle');
    }
}

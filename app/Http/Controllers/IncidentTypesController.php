<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\IncidentType;
use Illuminate\Http\Request;

class IncidentTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        $incident_types = IncidentType::when($request->search, function ($query) use ($request) {
            return $query->whereAny([
                'category',
                'incident_name',
            ], 'like', '%'  . $request->search . '%');
        })->paginate(10);

        return view('PAGES/admin/manage-incident-types', compact('incident_types'));
    }

    public function addIncidentTypes(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'incident_name' =>  'required|string|max:255|unique:incident_types,incident_name',
        ]);

        $incident_types = IncidentType::create([
            'category' => $request->category,
            'incident_name' => $request->incident_name,

        ]);

        if ($incident_types) {
            return redirect()->route('admin.incident-types')->with('success', 'Successfully Register Incident Types');
        } else {
            return redirect()->back()->with('error', 'Failed to Register Incident Types');
        }
    }

    public function edit($id)
    {
        $incident_types = IncidentType::findOrFail($id);



        return view('PAGES/admin/edit-incident-types', compact('incident_types'));
    }

    public function updateIncidentTypes(Request $request, $id)
    {

        $incident_types = IncidentType::findorFail($id);

        $request->validate([
            'category' => 'required|string|max:255',
            'incident_name' =>  'required|string|max:255',
        ]);

        $incident_types->update([
            'category' => $request->category,
            'incident_name' => $request->incident_name,

        ]);


        if ($incident_types) {
            return redirect()->route('admin.incident-types')->with('success', 'Successfully Edit Incident Types');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $incident_types = IncidentType::findOrFail($id)->delete();

        return $incident_types ? redirect()->back()->with('success', 'Successfully Delete Incident Types') : redirect()->back()->with('errors', 'Incident types delete fail');
    }
}

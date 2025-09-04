<?php

namespace App\Http\Controllers;

use App\Models\IncidentReport;
use Illuminate\Http\Request;

class AdminIncidentReportsController extends Controller
{
    public function index(Request $request)
    {
        $incidentreports = IncidentReport::when($request->search, function ($query) use ($request) {
            return $query->whereAny([
                'barangayNames',
                'municipals',
                'longitude',
                'latitude',
            ], 'like', '%'  . $request->search . '%');
        })->paginate(10);

        return view('PAGES/admin/manage-incident-reports', compact('incidentreports'));
    }

    public function addBarangay(Request $request)
    {
        $request->validate([
            'barangayNames' => 'required|string|max:255',
            'municipals' =>  'required|string|max:255',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
        ]);

        $incidentreports = IncidentReport::create([
            'barangayNames' => $request->barangayNames,
            'municipals' => $request->municipals,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude
        ]);

        if ($incidentreports) {
            return redirect()->route('manage-incident-reports.admin')->with('success', 'Successfully Register Incident Reports');
        } else {
            return redirect()->back()->with('error', 'Failed to Register Incident Reports');
        }
    }

    public function edit($id)
    {
        $incidentreports = IncidentReport::findOrFail($id);



        return view('PAGES/admin/edit-incident-reports', compact('incidentreports'));
    }

    public function updateIncidentReports(Request $request, $id)
    {

        $incidentreports = IncidentReport::findorFail($id);

        $request->validate([
            'barangayNames' => 'required|string|max:255',
            'municipals' =>  'required|string|max:255',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
        ]);

        $incidentreports->update([
            'barangayNames' => $request->barangayNames,
            'municipals' => $request->municipals,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude
        ]);


        if ($incidentreports) {
            return redirect()->route('manage-incident-reports.admin')->with('success', 'Successfully Modification Incident Reports');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $incidentreports = IncidentReport::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Successfully Delete Incident Reports');
    }
}

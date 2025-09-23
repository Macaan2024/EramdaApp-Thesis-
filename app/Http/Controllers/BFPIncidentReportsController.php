<?php

namespace App\Http\Controllers;

use App\Models\SubmitReport; // your model
use App\Models\Log; // if you also log incident actions
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BFPIncidentReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reports = SubmitReport::when($request->search, function ($query) use ($request) {
            $search = '%' . $request->search . '%';
            return $query->where(function ($q) use ($search) {
                $q->where('status', 'like', $search)
                  ->orWhere('description', 'like', $search)
                  ->orWhere('day', 'like', $search)
                  ->orWhere('month', 'like', $search);
            });
        })->paginate(10);

        return view('PAGES/BFP/manage-incident-reports', compact('reports'));
    }

    /**
     * Store a newly created incident report.
     */
    public function addReports(Request $request)
    {
        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'barangay_id'      => 'required|exists:barangays,id',
            'incident_types_id'=> 'required|exists:incident_types,id',
            'incidentLatitude' => 'nullable|numeric',
            'incidentLongitude'=> 'nullable|numeric',
            'numberOfDeaths'   => 'required|integer|min:0',
            'numberOfInjuries' => 'required|integer|min:0',
            'time'             => 'required|date_format:H:i',
            'day'              => 'required|string|max:20',
            'month'            => 'required|string|max:20',
            'status'           => 'required|string|max:50',
            'description'      => 'required|string',
        ]);

        $report = SubmitReport::create($request->all());

        if ($report) {
            Log::create([
                'interaction_type' => 'Add Incident Report',
                'user_id'          => Auth::id(),
                'agency_id'        => Auth::user()->agency_id ?? null,
                'submit_report_id' => $report->id,
            ]);

            return redirect()->route('bfp.incident-reports')
                ->with('success', 'Incident report submitted successfully.');
        }

        return redirect()->back()->with('error', 'Failed to submit incident report.');
    }

    /**
     * Show the form for editing the specified incident report.
     */
    public function edit($id)
    {
        $report = SubmitReport::findOrFail($id);

        return view('PAGES/BFP/edit-incident-report', compact('report'));
    }

    /**
     * Update the specified incident report.
     */
    public function updateReports(Request $request, $id)
    {
        $report = SubmitReport::findOrFail($id);

        $request->validate([
            'barangay_id'      => 'required|exists:barangays,id',
            'incident_types_id'=> 'required|exists:incident_types,id',
            'incidentLatitude' => 'nullable|numeric',
            'incidentLongitude'=> 'nullable|numeric',
            'numberOfDeaths'   => 'required|integer|min:0',
            'numberOfInjuries' => 'required|integer|min:0',
            'time'             => 'required|date_format:H:i',
            'day'              => 'required|string|max:20',
            'month'            => 'required|string|max:20',
            'status'           => 'required|string|max:50',
            'description'      => 'required|string',
        ]);

        $updated = $report->update($request->all());

        if ($updated) {
            Log::create([
                'interaction_type' => 'Update Incident Report',
                'user_id'          => Auth::id(),
                'agency_id'        => Auth::user()->agency_id ?? null,
                'submit_report_id' => $report->id,
            ]);
        }

        return $updated
            ? redirect()->route('bfp.incident-reports')->with('success', 'Incident report updated successfully.')
            : redirect()->back()->withErrors(['error' => 'Update failed, please try again.'])->withInput();
    }

    /**
     * Remove the specified incident report.
     */
    public function destroy($id)
    {
        $report = SubmitReport::findOrFail($id);

        Log::create([
            'interaction_type' => 'Delete Incident Report',
            'user_id'          => Auth::id(),
            'agency_id'        => Auth::user()->agency_id ?? null,
            'submit_report_id' => $report->id,
        ]);

        $deleted = $report->delete();

        return $deleted
            ? redirect()->back()->with('success', 'Incident report deleted successfully.')
            : redirect()->back()->with('error', 'Delete failed, please try again.');
    }

    /**
     * Display the specified incident report.
     */
    public function show($id)
    {
        $report = SubmitReport::find($id);

        if ($report) {
            return view('PAGES/BFP/view-incident-report', compact('report'));
        }

        return redirect()->back()->with('error', 'Incident report not found.');
    }
}

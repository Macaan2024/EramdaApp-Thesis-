<?php

namespace App\Http\Controllers;

use App\Models\SubmitReport;
use App\Models\Log;
use App\Models\Barangay;
use App\Models\IncidentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IncidentReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function submittedReports(Request $request)
    {
        $agencyId = Auth::user()->agency_id;

        $reports = SubmitReport::with(['barangay', 'incidentType'])
            ->where('agency_id', $agencyId) // only this agency’s data
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('description', 'like', '%' . $request->search . '%')
                        ->orWhere('status', 'like', '%' . $request->search . '%')
                        ->orWhereHas('barangay', function ($q2) use ($request) {
                            $q2->where('name', 'like', '%' . $request->search . '%');
                        })
                        ->orWhereHas('incidentType', function ($q2) use ($request) {
                            $q2->where('name', 'like', '%' . $request->search . '%');
                        });
                });
            })
            ->paginate(10);

        return view('PAGES/BFP_BDRRMC/submitted-reports', compact('reports'));
    }

    public function receiveReports(Request $request)
    {
        $reports = SubmitReport::with(['barangay', 'incidentType'])
            ->when($request->search, function ($query) use ($request) {
                $query->where('description', 'like', '%' . $request->search . '%')
                    ->orWhere('status', 'like', '%' . $request->search . '%')
                    ->orWhereHas('barangay', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('incidentType', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            })
            ->paginate(10);

        return view('PAGES/BFP_BDRRMC/receive-reports', compact('reports'));
    }

    public function requestReports(Request $request)
    {
        $reports = SubmitReport::with(['barangay', 'incidentType'])
            ->when($request->search, function ($query) use ($request) {
                $query->where('description', 'like', '%' . $request->search . '%')
                    ->orWhere('status', 'like', '%' . $request->search . '%')
                    ->orWhereHas('barangay', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('incidentType', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            })
            ->paginate(10);

        return view('PAGES/BFP_BDRRMC/request-reports', compact('reports'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($types)
    {
        $barangays = Barangay::all();
        $incidentTypes = IncidentType::where('category', $types)->get();

        return view('PAGES/BFP_BDRRMC/add-reports', compact('barangays', 'incidentTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addReports(Request $request)
    {
        $validated = $request->validate([
            'agency_id'       => 'required|exists:agencies,id',
            'incident_types_id' => 'required|exists:incident_types,id',
            'description'       => 'required|string',
            'barangay_id'       => 'required|exists:barangays,id',
            'incidentLongitude' => 'required|string',
            'incidentLatitude'  => 'required|string',
            'status'            => 'required|string',
        ]);

        $now = Carbon::now();

        SubmitReport::create([
            'agency_id'  => $validated['agency_id'],
            'incident_types_id'  => $validated['incident_types_id'],
            'description'        => $validated['description'],
            'barangay_id'        => $validated['barangay_id'],
            'incidentLongitude'  => $validated['incidentLongitude'],
            'incidentLatitude'   => $validated['incidentLatitude'],
            'time'               => $now->format('g:i A'), // AM/PM format
            'day'                => $now->format('d'),
            'month'              => $now->format('F'),
            'status'             => $validated['status'],
        ]);

        return redirect()->route('bfp.submitted-reports')
            ->with('success', 'Report submitted successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $report = SubmitReport::findOrFail($id);
        $barangays = Barangay::all();
        $incidentTypes = IncidentType::all();

        return view('PAGES/BFP_BDRRMC/edit-reports', compact('report', 'barangays', 'incidentTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $report = SubmitReport::findOrFail($id);

        $request->validate([
            'barangay_id'       => 'required|exists:barangays,id',
            'incident_types_id' => 'required|exists:incident_types,id',
            'incidentLatitude'  => 'nullable|numeric',
            'incidentLongitude' => 'nullable|numeric',
            'numberOfDeaths'    => 'nullable|integer|min:0',
            'numberOfInjuries'  => 'nullable|integer|min:0',
            'time'              => 'required|date_format:H:i',
            'day'               => 'required|string|max:20',
            'month'             => 'required|string|max:20',
            'status'            => 'nullable|string|max:50',
            'description'       => 'required|string|max:500',
        ]);

        $updated = $report->update($request->all());

        // Log action
        Log::create([
            'interaction_type'     => 'Update Incident Report',
            'agency_id'            => Auth::user()->agency_id ?? null,
            'submit_report_id'     => $report->id,
        ]);

        return $updated
            ? redirect()->route('bfp.manage-reports')->with('success', 'Incident Report successfully updated.')
            : redirect()->back()->with('error', 'Update failed, please try again.')->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $report = SubmitReport::with(['barangay', 'incidentType'])->findOrFail($id);

        return view('PAGES/BFP_BDRRMC/view-reports', compact('report'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $report = SubmitReport::findOrFail($id);

        // Log action before delete
        Log::create([
            'interaction_type'     => 'Delete Incident Report',
            'creator_user_id'      => Auth::id(),
            'agency_id'            => Auth::user()->agency_id ?? null,
            'submit_report_id'     => $report->id,
        ]);

        $report->delete();

        return redirect()->back()->with('success', 'Incident Report successfully deleted.');
    }
}

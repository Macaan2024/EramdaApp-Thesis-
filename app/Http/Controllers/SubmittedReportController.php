<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmittedReport;
use App\Models\Log;

class SubmittedReportController extends Controller
{
    public function submitReports(Request $request)
    {
        // ✅ Validate input
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'incident_category' => 'required|in:Disaster Incidents,Road Accidents',
            'incident_type' => 'required|string|max:255',
            'barangay_name' => ['required', 'regex:/^[A-Za-z\s\.\-\(\)]+$/'],
            'city_name' => 'required|in:Iligan City',
            'barangay_longitude' => 'required|numeric',
            'barangay_latitude' => 'required|numeric',
            'report_status' => 'required|in:Pending',

            // ✅ Now just string validation since we pass text (not user ID)
            'reported_by' => 'required|string|max:255',
            'from_agency' => 'required|string|max:255',
        ]);

        // ✅ Save to database
        $submittedReport = SubmittedReport::create($validatedData);

        // ✅ Keep your original flow
        if ($submittedReport) {
            Log::create([
                'interaction_type' => 'Add',
                'user_id' => auth()->user()->id,
                'submitted_report_id' => $submittedReport->id,
            ]);

            return redirect()
                ->route('admin.log-reports', 'All')
                ->with('success', 'Successfully Submitted Report');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to submit incident report.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgencyController extends Controller
{
    public function index(Request $request)
    {
        $agencies = Agency::when($request->search, function ($query) use ($request) {
            return $query->whereAny([
                'agencyNames',
                'agencyTypes',
                'address',
                'email',
                'longitude',
                'latitude',
                'activeStatus'
            ], 'like', '%'  . $request->search . '%');
        })->paginate(10);

        return view('PAGES/admin/manage-agencies', compact('agencies'));
    }


    public function submitAgency(Request $request)
    {
        $validatedData = $request->validate([
            'agencyNames' => 'required|string|unique:agencies,agencyNames',
            'agencyTypes' => 'required|in:BFP,BDRRMC,CDRRMO,HOSPITAL',
            'region' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string|in:Iligan City',
            'barangay' => 'required|string',
            'zipcode' => 'nullable|string',
            'email' => 'required|email|unique:agencies,email',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'availabilityStatus' => 'required|in:Available,Unavailable',
            'logo' => 'nullable|image|max:2048',
        ]);

        // Auto create address
        $validatedData['address'] = $validatedData['barangay'] . ', ' .
            $validatedData['city'] . ', ' .
            $validatedData['province'] . ', ' .
            $validatedData['region'];

        // Upload logo if exists
        if ($request->hasFile('logo')) {
            $validatedData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $submittedAgency = Agency::create($validatedData);


        return $submittedAgency ? redirect()->route('admin.agency')->with('success', 'Successfully Submitted Agency') : redirect()->back()->with('errors', 'Fail to Submit Agency')->withInput();
    }
}

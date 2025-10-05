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

    public function addAgency(Request $request)
    {
        $request->validate([
            'agencyNames'  => 'required|string|max:150|unique:agencies,agencyNames',
            'agencyTypes'  => 'required|string|max:100',
            'email'        => 'required|email|max:150|unique:agencies,email',
            'barangay'     => 'required|string|max:100',
            'city'         => 'required|string|max:100',
            'address'      => 'required|string|max:255',
            'longitude'    => 'required|numeric|between:-180,180',
            'latitude'     => 'required|numeric|between:-90,90',
            'zipcode'      => 'required|integer|digits:4', // ✅ must be integer and 4 digits
            'activeStatus' => 'required|in:Available,Inactive',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            // store in storage/app/public/logos
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $agencies = Agency::create([
            'agencyNames'  => $request->agencyNames,
            'agencyTypes'  => $request->agencyTypes,
            'barangay'      => $request->barangay,
            'address'      => $request->address,
            'email'        => $request->email,
            'city'         => $request->city,
            'longitude'    => $request->longitude,
            'latitude'     => $request->latitude,
            'zipcode'      => $request->zipcode,
            'activeStatus' => $request->activeStatus,
            'logo' => $logoPath

        ]);

        return $agencies
            ? redirect()->route('admin.agency')->with('success', 'Successfully Register Agency')
            : redirect()->back()->with('error', 'Failed to Register Agency');
    }


    public function edit($id)
    {
        $agency = Agency::findOrFail($id);

        $barangays = Barangay::orderBy('barangayNames', 'asc')->get();


        return view('PAGES/admin/edit-agencies', compact('agency', 'barangays'));
    }

    public function updateAgencies(Request $request, $id)
    {
        $agencies = Agency::findOrFail($id);

        $request->validate([
            'agencyNames'  => 'required|string|max:150|unique:agencies,agencyNames,' . $id,
            'agencyTypes'  => 'required|string|max:100',
            'email',
            Rule::unique('agencies', 'email')->ignore($id),
            'region'   => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'city'         => 'required|string|max:100',
            'address'      => 'required|string|max:255',
            'longitude'    => 'required|numeric|between:-180,180',
            'latitude'     => 'required|numeric|between:-90,90',
            'zipcode'      => 'required|integer|digits:4',
            'activeStatus' => 'required|in:Active,Inactive,Unavailable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);

        // keep old logo unless new uploaded
        $logoPath = $agencies->logo;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }


        $updated = $agencies->update([
            'agencyNames'  => $request->agencyNames,
            'agencyTypes'  => $request->agencyTypes,
            'address'      => $request->address,
            'email'        => $request->email,
            'city'         => $request->city,
            'longitude'    => $request->longitude,
            'latitude'     => $request->latitude,
            'zipcode'      => $request->zipcode,
            'activeStatus' => $request->activeStatus,
            'logo'         => $logoPath

        ]);

        return $updated
            ? redirect()->route('admin.agency')->with('success', 'Successfully Edit Agency')
            : redirect()->back()->with('errors', 'Fail to Update');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $agencies = Agency::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Successfully Delete Agency');
    }

    public function displayBarangay()
    {

        $barangays = Barangay::orderBy('barangayNames', 'asc')->get();

        return view('PAGES/admin/add-agencies', compact('barangays'));
    }
}

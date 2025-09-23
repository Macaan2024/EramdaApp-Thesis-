<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // we will use this for API calls


class BarangayController extends Controller
{
    public function index(Request $request)
    {
        $barangays = Barangay::when($request->search, function ($query) use ($request) {
            return $query->whereAny([
                'barangayNames',
                'city',
            ], 'like', '%'  . $request->search . '%');
        })->paginate(10);

        return view('PAGES/admin/manage-barangay', compact('barangays'));
    }

    public function addBarangay(Request $request)
    {
        $request->validate([
            'barangayNames' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        $barangay = Barangay::create([
            'barangayNames' => $request->barangayNames,
            'city' => $request->city,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

        if ($barangay) {
            return redirect()->route('admin.barangay')
                ->with('success', 'Successfully Registered Barangay with Coordinates');
        }

        return redirect()->back()->with('error', 'Failed to Register Barangay');
    }



    public function edit($id)
    {
        $barangays = Barangay::findOrFail($id);



        return view('PAGES/admin/edit-barangay', compact('barangays'));
    }

    public function updateBarangay(Request $request, $id)
    {

        $barangays = Barangay::findorFail($id);

        $request->validate([
            'barangayNames' => 'required|string|max:255',
            'city' =>  'required|string|max:255',
        ]);

        $barangays->update([
            'barangayNames' => $request->barangayNames,
            'city' => $request->municipals,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude
        ]);


        if ($barangays) {
            return redirect()->route('admin.barangay')->with('success', 'Successfully Edit Barangay');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barangays = Barangay::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Successfully Delete Barangay');
    }
}

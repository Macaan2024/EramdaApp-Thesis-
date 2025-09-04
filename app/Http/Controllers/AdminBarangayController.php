<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barangay;


class AdminBarangayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $barangays = Barangay::when($request->search, function ($query) use ($request) {
            return $query->whereAny([
                'barangayNames',
                'municipals',
                'longitude',
                'latitude',
            ], 'like', '%'  . $request->search . '%');
        })->paginate(10);

        return view('PAGES/admin/manage-barangay', compact('barangays'));
    }

    public function addBarangay(Request $request)
    {
        $request->validate([
            'barangayNames' => 'required|string|max:255',
            'municipals' =>  'required|string|max:255',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
        ]);

        $barangays = Barangay::create([
            'barangayNames' => $request->barangayNames,
            'municipals' => $request->municipals,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude
        ]);

        if ($barangays) {
            return redirect()->route('manage-barangay.admin')->with('success', 'Successfully Register Barangay');
        } else {
            return redirect()->back()->with('error', 'Failed to Register Barangay');
        }
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
            'municipals' =>  'required|string|max:255',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
        ]);

        $barangays->update([
            'barangayNames' => $request->barangayNames,
            'municipals' => $request->municipals,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude
        ]);


        if ($barangays) {
            return redirect()->route('manage-barangay.admin')->with('success', 'Successfully Edit Barangay');
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

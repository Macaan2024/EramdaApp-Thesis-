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
}

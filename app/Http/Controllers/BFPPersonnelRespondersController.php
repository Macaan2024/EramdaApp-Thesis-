<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\PersonnelResponder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BFPPersonnelRespondersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $responders = PersonnelResponder::with('user') // eager load user
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('firstname', 'like', '%' . $request->search . '%')
                        ->orWhere('lastname', 'like', '%' . $request->search . '%');
                });
            })
            ->paginate(10);

        return view('PAGES/BFP/manage-personnel-responders', compact('responders'));
    }


    public function register()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in');
        }

        $agency = Auth::user()->agency;

        return view('PAGES/BFP/add-personnel-responders', compact('agency'));
    }

    public function addResponders(Request $request)
    {
        // Validate form input first
        $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'user_type' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'gender' => 'required|in:m,f',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'contact_number' => 'required|string|max:255',
        ]);

        // Handle photo upload
        $photoPath = $request->hasFile('photo')
            ? $request->file('photo')->store('photos', 'public')
            : null;

        // Create user
        $user = User::create([
            'agency_id' => $request->agency_id,
            'user_type' => $request->user_type,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'gender' => $request->gender,
            'position' => $request->position,
            'photo' => $photoPath,
            'contact_number' => $request->contact_number,
        ]);



        PersonnelResponder::create([
            'user_id' => $user->id,
            'longitudeLocation' => null,
            'latitudeLocation' => null,
            'availabilityStatus' => 'available'
        ]);

        // Return with message
        return $user
            ? redirect()->route('bfp.respondersmanagement')
            : redirect()->back()
            ->withErrors(['errors' => 'Personnel Responders Adds Failed, please try again.'])
            ->withInput();
    }

    public function edit($id)
    {
        $responders = PersonnelResponder::findOrFail($id);



        return view('PAGES/BFP/edit-personnel-responders', compact('responders'));
    }

    public function updateBarangay(Request $request, $id)
    {

        $responders = PersonnelResponder::findorFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'agency_id' => 'required|exists:agencies,id',
            'longitudeLocation' => 'required|numeric',
            'latitudeLocation' => 'required|numeric',
            'availabilityStatus' => 'required|in:available,not available',
        ]);

        $responders->update($request->all());


        if ($responders) {
            return redirect()->route('bfp.manage-personnel-responders')->with('success', 'Successfully Modify Personnel Responders');
        } else {
            return redirect()->back()->with('error', 'Failed to Edit  Personnel Responder')->withInput();
        }
    }

    public function destroy($id)
    {
        $responders = PersonnelResponder::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Successfully Delete Barangay');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Log;
use App\Models\PersonnelResponder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // already imported at top
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

        //recording persnnelresponder registered
        $personnelResponder = PersonnelResponder::create([
            'user_id' => $user->id,
            'longitudeLocation' => null,
            'latitudeLocation' => null,
            'availabilityStatus' => 'available'
        ]);

        //logs records registers
        Log::create([
            'interaction_type' => 'Add Responder', // descriptive action
            'user_id' => auth()->user()->id,
            'agency_id' => auth()->user()->agency_id,
            'personnel_responder_id' => $personnelResponder->id,
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

    public function updateResponders(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'gender' => 'required|in:m,f',
            'position' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'email',
            'lastname',
            'firstname',
            'gender',
            'position',
            'contact_number',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $photoPath;
        }

        $updated = $user->update($data);

        $responder = PersonnelResponder::where('user_id', $id)->first();
        Log::create([
            'interaction_type' => 'Update Responder',
            'user_id' => auth()->id(),
            'agency_id' => auth()->user()->agency_id,
            'personnel_responder_id' => $responder->id ?? null
        ]);

        return $updated
            ? redirect()->route('bfp.respondersmanagement')->with('success', 'Successfully updated personnel responder.')
            : redirect()->back()
            ->withErrors(['error' => 'Update failed, please try again.'])
            ->withInput();
    }

    public function show($id)
    {
        $responder = PersonnelResponder::with('user')->findOrFail($id);

        return view('PAGES/BFP/view-personnel-responders', compact('responder'));
    }



    public function destroy($id)
    {
        $responder = PersonnelResponder::where('user_id', $id)->first();

        if ($responder) {
            $user = $responder->user; // keep reference to the user before deleting

            // Create log entry before deleting
            Log::create([
                'interaction_type' => 'Delete Responder',
                'user_id' => auth()->user()->id,
                'agency_id' => auth()->user()->agency_id,
                'personnel_responder_id' => $responder->id, // ✅ store responder ID
            ]);

            // Delete responder
            $responder->delete();

            // Delete user
            $user->delete();
        }

        return redirect()->back()->with('success', 'Successfully deleted personnel responder.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request, $status = 'all')
    {
        $sessionUser = auth()->user()->user_type;
        if ($sessionUser !== 'admin') {
            $responders = User::where('user_type', 'responders')
                ->where('agency_id', auth()->user()->agency_id)
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('firstname', 'like', '%' . $request->search . '%')
                            ->orWhere('id', 'like', '%' . $request->search . '%')
                            ->orWhere('lastname', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%')
                            ->orWhere('position', 'like', '%' . $request->search . '%')
                            ->orWhere('contact_number', 'like', '%' . $request->search . '%');
                    });
                })
                ->paginate(10);
            return view('PAGES/BFP_BDRRMC/manage-personnel-responders', compact('responders'));
        } else {
            $agencies = Agency::all();

            $responders = User::withTrashed()
                ->whereNot('user_type', 'admin')
                ->when($request->agency, function ($query) use ($request) {
                    $query->where('agency_id', $request->agency);
                })
                ->when($status === 'Archived', function ($query) {
                    $query->onlyTrashed();
                })
                ->when(in_array($status, ['Pending', 'Approved', 'Declined']), function ($query) use ($status) {
                    $query->where('account_status', ucfirst($status));
                })
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('firstname', 'like', '%' . $request->search . '%')
                            ->orWhere('id', 'like', '%' . $request->search . '%')
                            ->orWhere('lastname', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%')
                            ->orWhere('position', 'like', '%' . $request->search . '%')
                            ->orWhere('contact_number', 'like', '%' . $request->search . '%');
                    });
                })
                ->paginate(10);

            return view('PAGES/admin/personnel-responders', compact('responders', 'agencies', 'status'));
        }
    }


    public function register()
    {
        $agencies = Agency::all();

        return view('PAGES/admin/add-responders', compact('agencies'));
    }

    public function addResponders(Request $request)
    {
        // Validate form input
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
            'account_status' => 'required|in:Pending,Deactive,Activate',
            'availability_status' => 'required|in:Available,Unavailable',
        ]);

        // Handle photo upload
        $photoPath = $request->hasFile('photo')
            ? $request->file('photo')->store('photos', 'public')
            : null;

        // Create user
        $responder = User::create([
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
            'account_status' => $request->account_status,
            'availability_status' => $request->availability_status,
        ]);

        // Log action
        Log::create([
            'interaction_type' => 'Add Responder',
            'agency_id' => auth()->user()->agency_id,
            'user_id' => $responder->id,
        ]);

        return $responder
            ? redirect()->route('bfp.responders')->with('success', 'Successfully Register Responder.')
            : redirect()->back()->with('errors', 'Register fail, Please try again.')->withInput();
    }

    public function edit($id)
    {
        $sessionUser = auth()->user()->user_type;
        $responder = User::findOrFail($id);

        if ($sessionUser !== 'admin') {
            return view('PAGES/BFP_BDRRMC/edit-personnel-responders', compact('responder'));
        } else {
            return view('PAGES/admin/edit-personnel-responders', compact('responder'));
        }
    }

    public function updateResponders(Request $request, $id)
    {
        $sessionUser = auth()->user()->user_type;
        $responder = User::findOrFail($id);

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

        $updated = $responder->update($data);

        // Log action
        Log::create([
            'interaction_type' => 'Update Responder',
            'agency_id' => auth()->user()->agency_id,
            'user_id' => $responder->id,
        ]);

        if ($updated) {
            if ($sessionUser !== 'admin') {
                return redirect()->route('bfp.responders')->with('success', 'Successfully Update Responder');
            } else {
                return redirect()->route('admin.responders', 'All')->with('success', 'Successfully Update Responder');
            }
        } else {
            return redirect()->back()->withErrors('error', 'Update failed, please try again.')->withInput();
        }
    }

    public function show($id)
    {
        $responder = User::findOrFail($id);

        return view('PAGES/admin/view-responders', compact('responder'));
    }

    public function destroy($id)
    {
        $responder = User::findOrFail($id);

        $responder->update([
            'account_status' => 'Deleted',
            'availability_status' => 'Unavailable'
        ]);

        // Log action before delete
        Log::create([
            'interaction_type' => 'Delete Responder',
            'creator_user_id' => auth()->id(),
            'agency_id' => auth()->user()->agency_id,
            'user_id' => $responder->id,
        ]);

        $responder->delete();

        return $responder ? redirect()->back()->with('success', 'Responder successfully deleted.') : redirect()->back()->with('error', 'Responder delete fail');
    }


    public function restore($id)
    {
        $responder = User::withTrashed()->findOrFail($id);
        $responder->restore();

        $responder->update([
            'account_status' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Responder restored successfully.');
    }

    public function forceDelete($id)
    {
        $responder = User::withTrashed()->findOrFail($id);
        $responder->forceDelete();

        return redirect()->back()->with('success', 'Responder permanently deleted.');
    }


    public function accept($id)
    {
        $responder = User::findOrFail($id);
        $responder->update([
            'account_status' => 'Approved',
            'availability_status' => 'Available'
        ]);

        return redirect()->back()->with('success', 'Responder accepted successfully.');
    }

    public function decline($id)
    {
        $responder = User::findOrFail($id);
        $responder->update(['account_status' => 'Declined']);

        return redirect()->back()->with('success', 'Responder declined successfully.');
    }
}

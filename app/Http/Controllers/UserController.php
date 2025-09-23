<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('agency')
            ->when($request->search, function ($query) use ($request) {
                return $query->whereAny([
                    'firstname',
                    'lastname',
                    'email',
                    'position',
                ], 'like', '%' . $request->search . '%');
            })
            ->where('id', '!=', auth()->id()) // 🚀 exclude logged-in user
            ->orderByRaw("FIELD(account_status, 'Pending', 'Approved', 'Declined')") // custom order
            ->paginate(10);

        return view('PAGES/admin/manage-user', compact('users'));
    }

    public function approvedUsers(Request $request)
    {
        $users = User::with('agency')
            ->when($request->search, function ($query) use ($request) {
                return $query->whereAny([
                    'firstname',
                    'lastname',
                    'email',
                    'position',
                ], 'like', '%' . $request->search . '%');
            })
            ->where('id', '!=', auth()->id()) // 🚀 exclude logged-in user
            ->where('account_status', 'Approved')
            ->orderByRaw("FIELD(account_status, 'Pending', 'Approved', 'Declined')") // custom order
            ->paginate(10);

        return view('PAGES/admin/approved-user', compact('users'));
    }
    public function pendingUsers(Request $request)
    {
        $users = User::with('agency')
            ->when($request->search, function ($query) use ($request) {
                return $query->whereAny([
                    'firstname',
                    'lastname',
                    'email',
                    'position',
                ], 'like', '%' . $request->search . '%');
            })
            ->where('id', '!=', auth()->id()) // 🚀 exclude logged-in user
            ->where('account_status', 'Pending')
            ->orderByRaw("FIELD(account_status, 'Pending', 'Approved', 'Declined')") // custom order
            ->paginate(10);

        return view('PAGES/admin/pending-user', compact('users'));
    }
    public function declinedUsers(Request $request)
    {
        $users = User::with('agency')
            ->when($request->search, function ($query) use ($request) {
                return $query->whereAny([
                    'firstname',
                    'lastname',
                    'email',
                    'position',
                ], 'like', '%' . $request->search . '%');
            })
            ->where('id', '!=', auth()->id()) // 🚀 exclude logged-in user
            ->where('account_status', 'Declined')
            ->orderByRaw("FIELD(account_status, 'Pending', 'Approved', 'Declined')") // custom order
            ->paginate(10);

        return view('PAGES/admin/declined-user', compact('users'));
    }


    public function addUser(Request $request)
    {
        $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'user_type' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'gender' => 'required|in:m,f',
            'position' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);

        $userData = $request->except(['password', 'photo']);
        $userData['password'] = bcrypt($request->password);

        if ($request->hasFile('photo')) {
            $userData['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user = User::create($userData);

        if ($user) {
            return redirect()->route('admin.user')
                ->with('success', 'Successfully Registered User');
        }

        return redirect()->back()->with('error', 'Failed to Register User');
    }

    public function edit($id)
    {
        $user = User::with('agency')->findOrFail($id);
        $agencies = Agency::all();

        return view('PAGES/admin/edit-user', compact('user', 'agencies'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'user_type' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'gender' => 'required|in:m,f',
            'position' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);

        $userData = $request->except(['password', 'photo']);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $userData['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('photo')) {
            $userData['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user->update($userData);

        if ($user) {
            return redirect()->route('admin.user')
                ->with('success', 'Successfully Updated User');
        }

        return redirect()->back()->with('error', 'Failed to Update User');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Successfully Deleted User');
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);

        if ($user->account_status !== 'Approved') {
            $user->update([
                'account_status' => 'Approved',
                'availability_status' => 'Available'
            ]);
        }

        return redirect()->back()->with('success', 'User has been approved successfully!');
    }

    /**
     * Decline a pending user.
     */
    public function decline($id)
    {
        $user = User::findOrFail($id);

        if ($user->account_status !== 'Declined') {
            $user->update([
                'account_status' => 'Declined',
            ]);
        }

        return redirect()->back()->with('success', 'User has been declined successfully!');
    }

    public function add()
    {
        $agencies = Agency::all();

        return view('PAGES/admin/add-user', compact('agencies'));
    }

    public function show($id)
    {

        $user = User::findOrFail($id);

        return view('PAGES/admin/view-user', compact('user'));
    }
}

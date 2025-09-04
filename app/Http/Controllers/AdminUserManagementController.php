<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class AdminUserManagementController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->search, function ($query) use ($request){
            return $query->whereAny([
                'email',
                'lastname',
                'firstname',
                'position',
                'agencies',
            ], 'like', '%'  . $request->search . '%');
        })->paginate(10);

        return view('PAGES/admin/usermanagement', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addUser(Request $request)
    {
        $request->validate([
            'agencies' => 'required|string|max:255',
            'user_type' =>  'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'gender' => 'required|in:m,f',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'contact_number' => 'required|string|max:255',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $user = User::create([
            'agencies' => $request->agencies,
            'user_type' => $request->user_type,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'gender' => $request->gender,
            'position' => $request->position,
            'photo' => $photoPath,
            'contact_number' => $request->contact_number
        ]);

        

        if ($user) {
            return redirect()->route('usermanagement.admin')->with('success', 'Successfully Register User');
        } else {
            return redirect()->back()->with('error', 'Failed to Register User');
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);



        return view('PAGES/admin/edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {

        $user = User::findorFail($id);

        $request->validate([
            'agencies' => 'required|string|max:255',
            'user_type' =>  'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->ignore($id), // ✅ ignore current user
            ],
            'password' => 'required|string|min:8|confirmed',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'gender' => 'required|in:m,f',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'contact_number' => 'required|string|max:255',
        ]);

        $photoPath = $user->photo; // keep old photo by default
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $user->update([
            'agencies' => $request->agencies,
            'user_type' => $request->user_type,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'gender' => $request->gender,
            'position' => $request->position,
            'photo' => $photoPath,
            'contact_number' => $request->contact_number
        ]);


        if ($user) {
            return redirect()->route('usermanagement.admin')->with('success', 'Successfully Edit User');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Successfully Delete User');
    }
}

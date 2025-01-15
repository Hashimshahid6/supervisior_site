<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Packages;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(Auth::user()->role != 'Employee'){
            $packages = Packages::getAllPackages();
            $perPage = $request->input('per_page', 10);
            $users = User::getAllUsers()->paginate($perPage);
            return view('users.list', compact('users', 'packages'));
        }
        else{
            return view('errors.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'avatar' => 'nullable|file|mimes:jpeg,jpg,png,gif',
        ]);

        $avatarNumber = rand(1, 4).'.jpg';

        $avatarName = 'avatar-'.$avatarNumber;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('uploads/users'), $avatarName);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'avatar' => $avatarName ?? 'avatar-'.$avatarNumber,
            'password' => Hash::make($request->password),
            'role' => 'Employee',
        ]);

        return redirect()->route('users.index')->with('success', 'Employee added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return view('users.details', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'avatar' => 'nullable|file|mimes:jpeg,jpg,png,gif',
            'password' => 'nullable|min:8',
            'confirm_password' => 'nullable|same:password',
        ]);
        
        $user = User::find($id);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('uploads/users'), $avatarName);
            $user->avatar = $avatarName;
        }

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $test = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $user->password,
            'avatar' => $user->avatar,
        ]);
        
        // dd($test);
        return redirect()->route('users.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->status = 'Deleted';
        $user->save();
        return redirect()->route('users.index')->with('success', 'Employee deleted successfully.');
    }
}

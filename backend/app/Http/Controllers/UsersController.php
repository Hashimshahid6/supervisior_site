<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(Auth::user()->role != 'Employee'){
            $user = Auth::user();

            $query = User::query();

            if($user->type == 'Company'){
                $query->where('type', 'Employee');
            }

            if ($request->has('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->has('email')) {
                $query->where('email', 'like', '%' . $request->email . '%');
            }

            if ($request->has('role')) {
                $query->where('role', $request->role);
            }

            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('phone')) {
                $query->where('phone', 'like', '%' . $request->phone . '%');
            }

            if ($request->has('sort_by') && $request->has('sort_order')) {
                $query->orderBy($request->sort_by, $request->sort_order);
            }

            $users = $query->paginate($request->get('per_page', 10));

            return view('users.list', compact('users'));
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
        ]);

        $avatarNumber = rand(1, 4).'.jpg';

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'avatar' => 'avatar-'.$avatarNumber,
            'password' => bcrypt($request->password),
            'role' => 'Employee',
        ]);

        return redirect()->route('users.index')->with('success', 'Employee added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'avatar' => 'nullable|file|mimes:jpeg,jpg,png,gif',
        ]);

        $avatarNumber = rand(1, 4).'.jpg';
        
        $user = User::find($id);
        $user->password;

        if($request->password){
            $user->password = bcrypt($request->password);
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $user->password,
            'avatar' => 'avatar-'.$avatarNumber,
        ]);

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

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:master,admin,user',
            'phone_number' => 'required|phone:PL,INTERNATIONAL',
            'city' => 'required|string',
            'street' => 'required|string',
            'zip_code' => 'required|string',
            'rodo_accepted' => 'required|boolean'
        ]);

        $user = User::create($validatedData);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user)
    {
        $user = User::find($user);
        if(!$user){
            return response()->json(['message' => "Can't find user"], 404);
        };

        $validatedData = $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:8',
            'role' => 'in:superadmin,admin,user',
            'phone_number' => 'phone:PL,INTERNATIONAL',
            'city' => 'string',
            'street' => 'string',
            'zip_code' => 'string',
        ]);

        $user->update($validatedData);

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $user)
    {
        $user = User::find($user);
        if(!$user){
            return response()->json(['message' => "Can't find user"], 404);
        }

        if($user->id == $request->user()->id){
            return response()->json(['message' => "Can't delete yourself"], 403);
        }

        $user->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}

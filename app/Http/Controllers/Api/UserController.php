<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Centre;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $users = User::with('rendezVous.centre')->get();
    return response()->json($users);
}



    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'dateNaissance' => 'required|date',
        'address' => 'required|string',
        'phone' => 'required|string',
        'role' => 'sometimes|string',
        'sexe' => 'required|in:Homme,Femme',
        'groupeSanguin' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
    ]);
    $validated['password'] = bcrypt($validated['password']);


    $user = User::create($validated);
    return response()->json($user, 201); 
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $user = User::with('rendezVous.centre')->find($id);

    if ($user) {
        return response()->json($user);
    } else {
        return response()->json(['message' => 'User not found'], 404);
    }
}




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if ($user) {
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|max:255|unique:users,email,' . $id,
                'password' => 'sometimes|required|string|min:8|confirmed',
            ]);

            $user->update($request->all());
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Centre;

class Centrecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centres = Centre::all();
        if (!$centres) {
            return response()->json(['message' => 'No centres found'], 404);
        }
        return response()->json($centres);    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:centres',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $centre = Centre::create($request->all());
        return response()->json($centre, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $centre = Centre::find($id)->with('rendezVous');
        if ($centre){
            return response()->json($centre);
        }else{
            return response()->json(['message' => 'Centre not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $centre = Centre::find($id);
        if ($centre) {
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'address' => 'sometimes|required|string|max:255',
                'phone' => 'sometimes|required|string|max:15',
                'email' => 'sometimes|required|email|max:255|unique:centres,email,' . $id,
                'password' => 'sometimes|required|string|min:8|confirmed',
            ]);
            $centre->update($request->all());
            return response()->json($centre);
        } else {
            return response()->json(['message' => 'Centre not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $centre = Centre::find($id);
        if ($centre) {
            $centre->delete();
            return response()->json(['message' => 'Centre deleted successfully']);
        } else {
            return response()->json(['message' => 'Centre not found'], 404);
        }
    }
}

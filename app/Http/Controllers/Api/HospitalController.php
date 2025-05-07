<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospital;

class HospitalController extends Controller
{
    //
    public function index()
    {
        return response()->json(Hospital::all());
    }

     //
    public function show($id)
    {
        $hospital = Hospital::find($id);

        if (!$hospital) {
            return response()->json(['message' => 'Hospital not found'], 404);
        }

        return response()->json($hospital);
    }

    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $hospital = Hospital::create($validated);
        return response()->json($hospital, 201);
    }

    //
    public function update(Request $request, $id)
    {
        $hospital = Hospital::find($id);

        if (!$hospital) {
            return response()->json(['message' => 'Hospital not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string',
        ]);

        $hospital->update($validated);
        return response()->json($hospital);
    }

    //
    public function destroy($id)
    {
        $hospital = Hospital::find($id);

        if (!$hospital) {
            return response()->json(['message' => 'Hospital not found'], 404);
        }

        $hospital->delete();
        return response()->json(['message' => 'Hospital deleted successfully']);
    }
}

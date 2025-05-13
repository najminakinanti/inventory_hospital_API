<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Hospital;
use App\Models\Warehouse;

class AuthController extends Controller
{

    public function registerHospital(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:hospitals,email',
            'password' => 'required|min:6',
            'address' => 'nullable|string',
        ]);

        $hospital = Hospital::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'address' => $validated['address'],
        ]);

        $token = $hospital->createToken('hospital-token', ['hospital'])->plainTextToken;

        return response()->json([
            'user' => $hospital,
            'token' => $token,
        ]);
    }

    public function loginHospital(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $hospital = Hospital::where('email', $credentials['email'])->first();

        if (! $hospital || ! Hash::check($credentials['password'], $hospital->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $hospital->createToken('hospital-token', ['hospital'])->plainTextToken;

        return response()->json([
            'user' => $hospital,
            'token' => $token,
        ]);
    }
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil']);
    }

    public function registerWarehouse(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:warehouses,email',
            'password' => 'required|min:6',
            'address' => 'nullable|string',
        ]);

        $warehouse = Warehouse::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'address' => $validated['address'],
        ]);

        $token = $warehouse->createToken('warehouse-token', ['warehouse'])->plainTextToken;

        return response()->json([
            'user' => $warehouse,
            'token' => $token,
        ]);
    }

    public function loginWarehouse(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $warehouse = Warehouse::where('email', $credentials['email'])->first();

        if (! $warehouse || ! Hash::check($credentials['password'], $warehouse->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $warehouse->createToken('warehouse-token', ['warehouse'])->plainTextToken;

        return response()->json([
            'user' => $warehouse,
            'token' => $token,
        ]);
    }

}

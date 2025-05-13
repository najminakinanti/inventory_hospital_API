<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    //
    public function index()
    {
        return response()->json(Warehouse::all());
    }

    //
    public function show($id)
    {
        $warehouse = Warehouse::find($id);

        if (!$warehouse) {
            return response()->json(['message' => 'Warehouse not found'], 404);
        }

        return response()->json($warehouse);
    }

    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'required|email|unique:warehouses,email',
            'password' => 'nullable|string|min:6',
        ]);

        // Hash password jika ada
        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $warehouse = Warehouse::create($validated);
        return response()->json($warehouse, 201);
    }

    //
    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::find($id);

        if (!$warehouse) {
            return response()->json(['message' => 'Warehouse not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'sometimes|email|unique:warehouses,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $warehouse->update($validated);
        return response()->json($warehouse);
    }

    //
    public function destroy($id)
    {
        $warehouse = Warehouse::find($id);

        if (!$warehouse) {
            return response()->json(['message' => 'Warehouse not found'], 404);
        }

        $warehouse->delete();
        return response()->json(['message' => 'Warehouse deleted successfully']);
    }
}

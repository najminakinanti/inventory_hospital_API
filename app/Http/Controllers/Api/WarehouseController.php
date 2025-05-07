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
        return response()->json(Warehouse::with('items')->get());
    }

    //
    public function show($id)
    {
        $warehouse = Warehouse::with('items')->find($id);

        if (!$warehouse) {
            return response()->json(['message' => 'Warehouse not found'], 404);
        }

        return response()->json($warehouse);
    }

    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
        ]);

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
            'location' => 'sometimes|string|max:255',
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

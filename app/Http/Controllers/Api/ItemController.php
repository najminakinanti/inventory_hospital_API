<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{   
    // GET /items
    public function index(Request $request)
    {
        $query = Item::with('warehouse');

        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        return response()->json($query->get());
    }

    // public function index()
    // {
    //     // return response()->json(['message' => 'Route terpanggil'], 200);
    //     return response()->json(Item::with('warehouse')->get());
    // }

    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $item = Item::create($validated);
        return response()->json($item, 201);
    }

    //
    public function show($id)
    {
        $item = Item::with('warehouse')->find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json($item);
    }

    // 
    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'stock' => 'sometimes|integer|min:0',
            'kategori' => 'required|string',
            'warehouse_id' => 'sometimes|exists:warehouses,id',
        ]);

        $item->update($validated);
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->delete();
        return response()->json(['message' => 'Item deleted successfully']);
    }
}

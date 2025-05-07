<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        return response()->json(OrderItem::with(['order', 'item'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $orderItem = OrderItem::create($validated);
        return response()->json($orderItem, 201);
    }

    public function show($id)
    {
        $orderItem = OrderItem::with(['order', 'item'])->findOrFail($id);
        return response()->json($orderItem);
    }

    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);

        $validated = $request->validate([
            'order_id' => 'sometimes|exists:orders,id',
            'item_id' => 'sometimes|exists:items,id',
            'quantity' => 'sometimes|integer|min:1',
        ]);

        $orderItem->update($validated);
        return response()->json($orderItem);
    }

    public function destroy($id)
    {
        $OrderItem = OrderItem::find($id);

        if (!$OrderItem) {
            return response()->json(['message' => 'Order Item not found'], 404);
        }

        $OrderItem->delete();
        return response()->json(['message' => 'Order Item deleted successfully']);
    }
}

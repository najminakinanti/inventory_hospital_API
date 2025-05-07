<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::with(['orderItems.item', 'hospital'])->get());
    }

    public function show($id)
    {
        $order = Order::with(['orderItems.item', 'hospital'])->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'hospital_id' => $validated['hospital_id'],
            'order_date' => now(), 
            'status' => 'Diproses',
        ]);

        foreach ($validated['items'] as $itemData) {
            $item = Item::find($itemData['item_id']);

            if ($item->stock < $itemData['quantity']) {
                return response()->json([
                    'message' => "Stok tidak mencukupi untuk item {$item->name}"
                ], 400);
            }

            $item->stock -= $itemData['quantity'];
            $item->save();

            $order->orderItems()->create([
                'item_id' => $itemData['item_id'],
                'quantity' => $itemData['quantity'],
            ]);
        }

        return response()->json($order->load(['orderItems.item', 'hospital']), 201);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $validated = $request->validate([
            'order_date' => 'sometimes|date',
            'status' => 'sometimes|in:Diproses,Dikirim,Selesai',
        ]);

        $order->update($validated);

        return response()->json($order);
    }

    // DELETE /orders/{id}
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }

    // PUT /orders/{id}/status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diproses,Dikirim,Selesai',
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json($order);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/order-items",
     *     summary="Get all order items",
     *     tags={"Order Items"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of order items",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/OrderItem")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Server error")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $orderItems = OrderItem::with(['order', 'item'])->get();
            return response()->json($orderItems);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/order-items",
     *     summary="Create a new order item",
     *     tags={"Order Items"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"order_id", "item_id", "quantity"},
     *             @OA\Property(property="order_id", type="integer", example=1),
     *             @OA\Property(property="item_id", type="integer", example=2),
     *             @OA\Property(property="quantity", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order item created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/OrderItem")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Server error")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|exists:orders,id',
                'item_id' => 'required|exists:items,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $orderItem = OrderItem::create($validated);
            return response()->json($orderItem, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/order-items/{id}",
     *     summary="Get order item detail by ID",
     *     tags={"Order Items"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order Item ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order item detail",
     *         @OA\JsonContent(ref="#/components/schemas/OrderItem")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order item not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Order item not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Server error")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $orderItem = OrderItem::with(['order', 'item'])->find($id);

            if (!$orderItem) {
                return response()->json(['message' => 'Order item not found'], 404);
            }

            return response()->json($orderItem);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/order-items/{id}",
     *     summary="Update an order item by ID",
     *     tags={"Order Items"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order Item ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="order_id", type="integer", example=1),
     *             @OA\Property(property="item_id", type="integer", example=5),
     *             @OA\Property(property="quantity", type="integer", example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order item updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/OrderItem")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order item not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Order item not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Server error")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $orderItem = OrderItem::find($id);

            if (!$orderItem) {
                return response()->json(['message' => 'Order item not found'], 404);
            }

            $validated = $request->validate([
                'order_id' => 'sometimes|exists:orders,id',
                'item_id' => 'sometimes|exists:items,id',
                'quantity' => 'sometimes|integer|min:1',
            ]);

            $orderItem->update($validated);

            return response()->json($orderItem);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/order-items/{id}",
     *     summary="Delete an order item by ID",
     *     tags={"Order Items"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order Item ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order item deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Order Item deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order item not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Order Item not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Server error")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $orderItem = OrderItem::find($id);

            if (!$orderItem) {
                return response()->json(['message' => 'Order Item not found'], 404);
            }

            $orderItem->delete();

            return response()->json(['message' => 'Order Item deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }
}

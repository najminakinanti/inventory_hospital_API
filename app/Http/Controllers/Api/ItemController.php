<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{   
    
    /**
     * @OA\Get(
     *     path="/api/items",
     *     summary="Get all items and Get by category",
     *     description="Returns a list of items, optionally filtered by category",
     *     tags={"Items"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="kategori",
     *         in="query",
     *         description="Filter items by kategori",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"AlatBantu", "Furniture", "Monitoring", "Sterilisasi", "Bedah", "Laboratorium", "ProteksiDiri", "Lainnya"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Item")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to fetch items"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            $query = Item::with('warehouse');

            if ($request->has('kategori')) {
                $query->where('kategori', $request->kategori);
            }

            return response()->json($query->get(), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch items',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/items",
     *     summary="Create a new item",
     *     tags={"Items"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description", "stock", "kategori", "warehouse_id"},
     *             @OA\Property(property="name", type="string", example="Alat Ukur Tekanan"),
     *             @OA\Property(property="description", type="string", example="Digunakan untuk mengukur tekanan darah"),
     *             @OA\Property(property="stock", type="integer", example=10),
     *             @OA\Property(
     *                 property="kategori",
     *                 type="string",
     *                 enum={"AlatBantu", "Furniture", "Monitoring", "Sterilisasi", "Bedah", "Laboratorium", "ProteksiDiri", "Lainnya"},
     *                 example="Monitoring"
     *             ),
     *             @OA\Property(property="warehouse_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Item created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Item")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'stock' => 'required|integer|min:0',
                'kategori' => 'required|string|in:AlatBantu,Furniture,Monitoring,Sterilisasi,Bedah,Laboratorium,ProteksiDiri,Lainnya',
                'warehouse_id' => 'sometimes|exists:warehouses,id',
            ]);

            $item = Item::create($validated);
            return response()->json($item, 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/items/{id}",
     *     summary="Get item by ID",
     *     tags={"Items"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the item to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item data retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Item")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Item not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Server error: Something went wrong")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $item = Item::with('warehouse')->find($id);

            if (!$item) {
                return response()->json(['message' => 'Item not found'], 404);
            }

            return response()->json($item);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/items/{id}",
     *     summary="Update an existing item",
     *     tags={"Items"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the item to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", maxLength=255, example="Stetoskop"),
     *             @OA\Property(property="description", type="string", example="Alat untuk mendengar detak jantung"),
     *             @OA\Property(property="stock", type="integer", example=10),
     *             @OA\Property(property="kategori", type="string", example="Monitoring"),
     *             @OA\Property(property="warehouse_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Item")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Item not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Server error: Something went wrong")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/items/{id}",
     *     summary="Delete an item by ID",
     *     tags={"Items"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Item ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Item deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Item not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Server error: Something went wrong")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $item = Item::find($id);

            if (!$item) {
                return response()->json(['message' => 'Item not found'], 404);
            }

            $item->delete();

            return response()->json(['message' => 'Item deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/warehouses",
     *     summary="Get all warehouses",
     *     tags={"Warehouses"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Warehouse"))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Failed to fetch warehouses"))
     *     )
     * )
     */
    public function index()
    {
        try {
            return response()->json(Warehouse::all(), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch warehouses', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/warehouses/{id}",
     *     summary="Get a warehouse by ID",
     *     tags={"Warehouses"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success", @OA\JsonContent(ref="#/components/schemas/Warehouse")),
     *     @OA\Response(response=404, description="Not Found", @OA\JsonContent(@OA\Property(property="message", type="string"))),
     *     @OA\Response(response=500, description="Server error", @OA\JsonContent(@OA\Property(property="message", type="string")))
     * )
     */
    public function show($id)
    {
        try {
            $warehouse = Warehouse::find($id);

            if (!$warehouse) {
                return response()->json(['message' => 'Warehouse not found'], 404);
            }

            return response()->json($warehouse);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch warehouse', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/warehouses/{id}",
     *     summary="Update a warehouse",
     *     tags={"Warehouses"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated successfully", @OA\JsonContent(ref="#/components/schemas/Warehouse")),
     *     @OA\Response(response=404, description="Not found", @OA\JsonContent(@OA\Property(property="message", type="string"))),
     *     @OA\Response(response=422, description="Validation error", @OA\JsonContent(@OA\Property(property="message", type="string"), @OA\Property(property="errors", type="object"))),
     *     @OA\Response(response=500, description="Server error", @OA\JsonContent(@OA\Property(property="message", type="string")))
     * )
     */
    public function update(Request $request, $id)
    {
        try {
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/warehouses/{id}",
     *     summary="Delete a warehouse by ID",
     *     tags={"Warehouses"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Warehouse ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Warehouse deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Warehouse deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Warehouse not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Warehouse not found")
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
    public function destroy($id)
    {
        try {
            $warehouse = Warehouse::find($id);
            if (!$warehouse) {
                return response()->json(['message' => 'Warehouse not found'], 404);
            }

            $warehouse->delete();
            return response()->json(['message' => 'Warehouse deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}

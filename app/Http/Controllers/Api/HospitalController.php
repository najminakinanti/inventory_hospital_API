<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospital;

class HospitalController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/hospitals",
     *     summary="Get all hospitals",
     *     tags={"Hospitals"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Hospital")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to fetch hospitals")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $hospitals = Hospital::all();
            return response()->json($hospitals, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch hospitals', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/hospitals/{id}",
     *     summary="Get a hospital by ID",
     *     tags={"Hospitals"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the hospital",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Hospital")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hospital not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Hospital not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to fetch hospital"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $hospital = Hospital::find($id);

            if (!$hospital) {
                return response()->json(['message' => 'Hospital not found'], 404);
            }
            return response()->json($hospital, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch hospital', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/hospitals/{id}",
     *     summary="Update hospital data",
     *     tags={"Hospitals"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Hospital ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hospital updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Hospital")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hospital not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Hospital not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
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
    public function update(Request $request, Hospital $hospital)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string',
                'email' => 'sometimes|email|unique:warehouses,email,' . $id,
                'password' => 'nullable|string|min:6',
            ]);
            $hospital->update($validated);

            return response()->json($hospital);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/hospitals/{id}",
     *     summary="Delete a hospital by ID",
     *     tags={"Hospitals"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Hospital ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hospital deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Hospital deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hospital not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Hospital not found")
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
            $hospital = Hospital::find($id);

            if (!$hospital) {
                return response()->json(['message' => 'Hospital not found'], 404);
            }

            $hospital->delete();
            return response()->json(['message' => 'Hospital deleted successfully']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}

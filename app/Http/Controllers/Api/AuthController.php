<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Hospital;
use App\Models\Warehouse;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register/hospital",
     *     summary="Register a new hospital user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="RS Sehat Sentosa"),
     *             @OA\Property(property="email", type="string", format="email", example="hospital@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123"),
     *             @OA\Property(property="address", type="string", example="Jl. Merdeka No. 10, Jakarta")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hospital registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="RS Sehat Sentosa"),
     *                 @OA\Property(property="email", type="string", example="hospital@example.com"),
     *                 @OA\Property(property="address", type="string", example="Jl. Merdeka No. 10, Jakarta"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-20T10:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-20T10:00:00Z"),
     *             ),
     *             @OA\Property(property="token", type="string", example="1|Y9o...v7A")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validasi gagal"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="email", type="array",
     *                     @OA\Items(type="string", example="The email has already been taken.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *             @OA\Property(property="error", type="string", example="SQLSTATE[23000]: Integrity constraint violation: ...")
     *         )
     *     )
     * )
     */
    public function registerHospital(Request $request)
    {
        try {
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
                'address' => $validated['address'] ?? null,
            ]);

            $token = $hospital->createToken('hospital-token', ['hospital'])->plainTextToken;

            return response()->json(['user' => $hospital, 'token' => $token,], 200); 

        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors(),], 422); 

        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage(),], 500); 
        }
    }

    /**
     * @OA\Post(
     *     path="/api/login/hospital",
     *     summary="Login hospital user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="hospital@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="RS Sehat Sentosa"),
     *                 @OA\Property(property="email", type="string", example="hospital@example.com"),
     *                 @OA\Property(property="address", type="string", example="Jl. Merdeka No. 10, Jakarta"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-20T10:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-20T10:00:00Z")
     *             ),
     *             @OA\Property(property="token", type="string", example="1|Y9o...v7A")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Kredensial tidak valid")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validasi gagal"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="email", type="array",
     *                     @OA\Items(type="string", example="The email field is required.")
     *                 ),
     *                 @OA\Property(property="password", type="array",
     *                     @OA\Items(type="string", example="The password field is required.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan pada server"),
     *             @OA\Property(property="error", type="string", example="SQLSTATE[23000]: Integrity constraint violation...")
     *         )
     *     )
     * )
     */
    public function loginHospital(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $hospital = Hospital::where('email', $credentials['email'])->first();

            if (!$hospital || !Hash::check($credentials['password'], $hospital->password)) {
                return response()->json(['message' => 'Kredensial tidak valid',], 401);
            }

            $token = $hospital->createToken('hospital-token', ['hospital'])->plainTextToken;

            return response()->json(['user' => $hospital, 'token' => $token,], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors(),], 422);

        } catch (\Exception $e) {
            Log::error('Error saat login rumah sakit: ' . $e->getMessage());

            return response()->json(['message' => 'Terjadi kesalahan pada server', 'error' => $e->getMessage(),], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout user",
     *     tags={"Auth"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logout berhasil")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Tidak terautentikasi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Tidak terautentikasi")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Terjadi kesalahan pada server",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan pada server")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logout berhasil',], 200);


        } catch (\Exception $e) {
            // Menangani error umum (HTTP 500)
            Log::error('Error saat logout: ' . $e->getMessage());

            return response()->json([
                'message' => 'Terjadi kesalahan pada server',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/register/warehouse",
     *     summary="Register a new warehouse user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Gudang Sejahtera"),
     *             @OA\Property(property="email", type="string", format="email", example="warehouse@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="rahasia123"),
     *             @OA\Property(property="address", type="string", example="Jl. Industri No. 123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful registration",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Gudang Sejahtera"),
     *                 @OA\Property(property="email", type="string", example="warehouse@example.com"),
     *                 @OA\Property(property="address", type="string", example="Jl. Industri No. 123"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-20T10:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-20T10:00:00Z")
     *             ),
     *             @OA\Property(property="token", type="string", example="1|xYZ...token_string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validasi gagal"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="email", type="array",
     *                     @OA\Items(type="string", example="The email has already been taken.")
     *                 ),
     *                 @OA\Property(property="password", type="array",
     *                     @OA\Items(type="string", example="The password must be at least 6 characters.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *             @OA\Property(property="error", type="string", example="SQLSTATE[23000]: Integrity constraint violation...")
     *         )
     *     )
     * )
     */
    public function registerWarehouse(Request $request)
    {
        try {
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
                'address' => $validated['address'] ?? null,
            ]);

            $token = $warehouse->createToken('warehouse-token', ['warehouse'])->plainTextToken;

            return response()->json(['user' => $warehouse, 'token' => $token,], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors(),], 422);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage(),], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/login/warehouse",
     *     summary="Login warehouse user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="warehouse@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="rahasia123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Gudang Satu"),
     *                 @OA\Property(property="email", type="string", example="warehouse@example.com"),
     *                 @OA\Property(property="address", type="string", example="Jl. Industri No. 1, Bandung"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-20T10:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-20T10:00:00Z")
     *             ),
     *             @OA\Property(property="token", type="string", example="1|Xyz...123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Kredensial tidak valid")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validasi gagal"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="email", type="array",
     *                     @OA\Items(type="string", example="The email field is required.")
     *                 ),
     *                 @OA\Property(property="password", type="array",
     *                     @OA\Items(type="string", example="The password field is required.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan pada server"),
     *             @OA\Property(property="error", type="string", example="SQLSTATE[23000]: Integrity constraint violation...")
     *         )
     *     )
     * )
     */
    public function loginWarehouse(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $warehouse = Warehouse::where('email', $credentials['email'])->first();

            if (! $warehouse || ! Hash::check($credentials['password'], $warehouse->password)) {
                return response()->json(['message' => 'Kredensial tidak valid'], 401);
            }

            $token = $warehouse->createToken('warehouse-token', ['warehouse'])->plainTextToken;

            return response()->json(['user' => $warehouse, 'token' => $token,], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors(),], 422);

        } catch (\Exception $e) {
            \Log::error('Error saat login warehouse: ' . $e->getMessage());

            return response()->json(['message' => 'Terjadi kesalahan pada server', 'error' => $e->getMessage(),], 500);
        }
    }
}

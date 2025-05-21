<?php

namespace App\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Hospital-Inventory Information System API",
 *     version="1.0.0",
 *     description="This API enables seamless interaction between hospitals and warehouses to manage and distribute healthcare items in real-time. Hospitals can place orders, warehouses manage inventory, and order statuses are tracked accurately. All endpoints require Bearer token authentication for secure access."
 * )
 * 
 * @OA\Tag(
 *     name="Auth",
 *     description="Authentication process for hospitals and warehouses"
 * )
 * 
 * @OA\Tag(
 *     name="Hospitals",
 *     description="Hospital account management"
 * )
 * 
 * @OA\Tag(
 *     name="Items",
 *     description="Manage the list of available items"
 * )
 * 
 * @OA\Tag(
 *     name="Orders",
 *     description="Manage order requests containing a collection of order items"
 * )
 * 
 * @OA\Tag(
 *     name="Order Items",
 *     description="Handles specific items ordered by the hospital"
 * )
 * 
 * @OA\Tag(
 *     name="Warehouses",
 *     description="Warehouse account management"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Masukkan token Bearer"
 * )
 * @OA\Server(
 *     url="http://localhost:8000"
 * )
 */
class OpenApiAnnotations
{
    // 
}

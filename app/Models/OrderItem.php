<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="OrderItem",
 *     type="object",
 *     title="OrderItem",
 *     @OA\Property(property="id", type="integer", description="Auto-generated ID"),
 *     @OA\Property(
 *         property="order_id",
 *         type="integer",
 *         description="ID of the order",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="item_id",
 *         type="integer",
 *         description="ID of the item",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="quantity",
 *         type="integer",
 *         description="Quantity of item in the order",
 *         example=5
 *     )
 * )
 */
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'item_id',
        'quantity',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Order",
 *     type="object",
 *     title="Order",
 *     @OA\Property(property="id", type="integer", description="Auto-generated ID"),
 *     @OA\Property(property="hospital_id", type="integer", example=2, description="ID rumah sakit yang melakukan pemesanan"),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"Diproses", "Dikirim", "Selesai"},
 *         example="Diproses",
 *     ),
 *     @OA\Property(
 *         property="order_date",
 *         type="string",
 *         format="date-time",
 *         example="2024-05-20T10:00:00Z",
 *         description="Tanggal pemesanan"
 *     )
 * )
 */

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'status',
        'order_date',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}

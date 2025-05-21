<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Warehouse;

/**
 * @OA\Schema(
 *     schema="Item",
 *     title="Item",
 *     @OA\Property(property="id", type="integer", description="Auto-generated ID"),
 *     @OA\Property(property="name", type="string", example="Monitor Tekanan Darah"),
 *     @OA\Property(property="description", type="string", example="Alat untuk mengukur tekanan darah secara otomatis."),
 *     @OA\Property(property="stock", type="integer", example=20),
 *     @OA\Property(
 *         property="kategori",
 *         type="string",
 *         enum={"AlatBantu", "Furniture", "Monitoring", "Sterilisasi", "Bedah", "Laboratorium", "ProteksiDiri", "Lainnya"},
 *         example="Monitoring"
 *     ),
 *     @OA\Property(property="warehouse_id", type="integer", example=5)
 * )
 */

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stock',
        'warehouse_id',
        'kategori', 
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    
}

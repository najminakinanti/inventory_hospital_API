<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Warehouse;

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

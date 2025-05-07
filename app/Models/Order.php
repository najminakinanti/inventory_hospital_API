<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

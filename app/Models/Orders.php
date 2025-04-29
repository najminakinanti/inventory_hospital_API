<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'hospital_id',
        'quantity',
        'status',
        'order_date',
    ];

    public function item()
    {
        return $this->belongsTo(Items::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospitals::class);
    }
}

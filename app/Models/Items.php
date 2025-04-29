<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stock',
        'warehouse_id',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouses::class);
    }

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }
}

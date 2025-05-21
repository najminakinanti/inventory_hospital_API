<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Warehouse",
 *     type="object",
 *     title="Warehouse",
 *     @OA\Property(property="id", type="integer", description="Auto-generated ID"),
 *     @OA\Property(property="name", type="string", example="Gudang Jogja"),
 *     @OA\Property(property="email", type="string", format="email", example="gudangjogja@gmail.com"),
 *     @OA\Property(property="address", type="string", example="Jl. Persatuan No. 10"),
 *     @OA\Property(property="password", type="string", example="rahasia123"),
 * )
 */
class Warehouse extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'address',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function item()
    {
        return $this->hasMany(Item::class);
    }
    
}

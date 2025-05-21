<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Hospital",
 *     type="object",
 *     title="Hospital",
 *     @OA\Property(property="id", type="integer", description="Auto-generated ID"),
 *     @OA\Property(property="name", type="string", example="RS Harapan Sehat"),
 *     @OA\Property(property="email", type="string", format="email", example="admin@rsharapan.com"),
 *     @OA\Property(property="address", type="string", example="Jl. Sehat No. 10"),
 *     @OA\Property(property="password", type="string", example="rahasia123"),
 * )
 */

class Hospital extends Model
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

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}

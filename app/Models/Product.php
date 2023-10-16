<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'price',
    ];

    public static function getProductId($id, $name, $price): int
    {
        return self::query()
            ->firstOrCreate(
                ['user_id' => $id, 'name' => $name, 'price' => $price],
            )['id'];
    }
}

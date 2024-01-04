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
        'category_id',
        'price',
    ];

    public static function getId($category_id, $price): int
    {
        return self::query()
            ->firstOrCreate([
                'category_id' => $category_id,
                'price' => $price,
            ])['id'];
    }
}

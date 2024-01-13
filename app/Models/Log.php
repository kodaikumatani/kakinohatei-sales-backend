<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date_time',
        'producer_code',
        'producer',
        'store',
        'product',
        'price',
        'quantity',
        'store_sum',
    ];

    /**
     * キャストする必要のある属性
     *
     * @var array
     */
    protected $casts = [
        'date_time' => 'datetime',
        'producer_code' => 'integer',
        'producer' => 'string',
        'store' => 'string',
        'product' => 'string',
        'price' => 'integer',
        'quantity' => 'integer',
        'store_sum' => 'integer',
    ];
}

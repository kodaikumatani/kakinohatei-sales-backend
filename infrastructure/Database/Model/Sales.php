<?php

namespace Infrastructure\Database\Model;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    /**
     * Attributes for multiple assignments
     *
     * @var array
     */
    protected $fillable = [
        "received_at",
        "store_id",
        "recorded_at",
        "product_id",
        "price",
        "quantity",
        "store_sum",
    ];
}
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
        "provider_id",
        "store_id",
        "recorded_at",
        "product_id",
        "price",
        "quantity",
        "store_sum",
    ];
}
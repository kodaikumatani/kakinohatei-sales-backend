<?php

namespace Infrastructure\Database\Model;

use Illuminate\Database\Eloquent\Model;

class DailyAccounting extends Model
{
    /**
     * Attributes for multiple assignments
     *
     * @var array
     */
    protected $fillable = [
        "received_at",
        "store_id",
        "product_id",
        "price",
        "quantity",
        "store_sum",
    ];
}
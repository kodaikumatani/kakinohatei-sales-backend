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
        "provider_id",
        "store_id",
        "record_date",
        "product_id",
        "price",
        "quantity",
        "store_sum",
    ];
}
<?php

namespace Infrastructure\Database\Model;

use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
    /**
     * Attributes for multiple assignments
     *
     * @var array
     */
    protected $fillable = [
        'received_at',
        'sales'
    ];
}
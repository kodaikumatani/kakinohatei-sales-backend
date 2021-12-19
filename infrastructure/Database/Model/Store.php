<?php

namespace Infrastructure\Database\Model;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /**
     * Attributes for multiple assignments
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
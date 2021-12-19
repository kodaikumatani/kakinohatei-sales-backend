<?php

namespace Infrastructure\Database\Model;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    /**
     * Attributes for multiple assignments
     *
     * @var array
     */
    protected $fillable = [
        'provider_id',
        'name'
    ];
}
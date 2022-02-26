<?php

namespace Infrastructure\Database\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Attributes for multiple assignments
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
    
    public function doesntExistRecord($name)
    {
    	return $this->where('name', $name)->doesntExist();
    }
    
    public function getId($name)
    {
        return $this->where('name', $name)->value('id');
    }
}
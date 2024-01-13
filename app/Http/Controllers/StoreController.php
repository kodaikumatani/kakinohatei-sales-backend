<?php

namespace App\Http\Controllers;

use App\Models\Store;

class StoreController extends Controller
{
    /**
     * @param  string  $name
     * @return int
     */
    public function firstOrCreate($name)
    {
        return Store::firstOrCreate(['name' => $name])['id'];
    }
}

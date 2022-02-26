<?php

namespace Infrastructure\Database\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Infrastructure\Database\Model\Store;

class StoresController extends Controller
{
    public function getId($name)
    {
        $store = new Store;
        if ($store->doesntExistRecord($name)) {
            // If it's an unregistered store, add it.
            Store::create(['name' => $name]);
        }
        return $store->getID($name);
    }
}
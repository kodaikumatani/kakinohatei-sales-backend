<?php

namespace Infrastructure\Database\Controller;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Infrastructure\Database\Model\Store;

class StoresController extends Controller
{
    public function getId($name)
    {
        if (DB::table('stores')->where('name', $name)->doesntExist()) {
            // If it's an unregistered store, add it.
            Store::create(['name' => $name]);
        }
        return DB::table('stores')->where('name', $name)->value('id');
    }
}
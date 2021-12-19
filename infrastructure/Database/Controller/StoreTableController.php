<?php

namespace Infrastructure\Database\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Infrastructure\Database\Model\Store;

class StoreTableController extends Controller
{
    public function getId($name)
    {
        $client = new Store();
        if (DB::table('stores')->where('name', $name)->doesntExist()) {
            // If it's an unregistered store, add it.
            $client->fill(['name' => $name])->save();
        }
        return DB::table('stores')->where('name', $name)->value('id');
    }
}
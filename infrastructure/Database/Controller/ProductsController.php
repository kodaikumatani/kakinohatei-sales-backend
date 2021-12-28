<?php

namespace Infrastructure\Database\Controller;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Infrastructure\Database\Model\Product;

class ProductsController extends Controller
{
    public function getId($name)
    {
        if (DB::table('products')->where('name', $name)->doesntExist()) {
            // If there are no products in the table, add them.
            Product::create(['name' => $name]);
        }
        return DB::table('products')->where('name', $name)->value('id');
    }
}
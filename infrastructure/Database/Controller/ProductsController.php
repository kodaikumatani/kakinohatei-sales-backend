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
            $productID = 999;
            do {
                $productID += 1;
                $exist = DB::table('products')->where('product_id', $productID)->exists();
            } while ($exist);
            
            Product::create([
                'product_id' => $productID,
                'name' => $name
            ]);
        }
        return DB::table('products')->where('name', $name)->value('product_id');
    }
}
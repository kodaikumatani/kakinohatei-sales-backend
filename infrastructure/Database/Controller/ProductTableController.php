<?php

namespace Infrastructure\Database\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Infrastructure\Database\Model\Product;

class ProductTableController extends Controller
{
    public function getId($name)
    {
        $client = new Product();
        if (DB::table('products')->where('name', $name)->doesntExist()) {
            // If there are no products in the table, add them.
            $productID = 999;
            do {
                $productID += 1;
                $exist = DB::table('products')->where('product_id', $productID)->exists();
            } while ($exist);
            
            $client->fill([
                'product_id' => $productID,
                'name' => $name
            ]);
            $client->save();
        }
        return DB::table('products')->where('name', $name)->value('product_id');
    }
}
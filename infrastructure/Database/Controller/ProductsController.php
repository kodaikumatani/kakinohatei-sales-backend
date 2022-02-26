<?php

namespace Infrastructure\Database\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Infrastructure\Database\Model\Product;

class ProductsController extends Controller
{
    public function getId($name)
    {
        $product = new Product;
        if ($product->doesntExistRecord($name)) {
            // If it's an unregistered store, add it.
            Product::create(['name' => $name]);
        }
        return $product->getID($name);
    }
}
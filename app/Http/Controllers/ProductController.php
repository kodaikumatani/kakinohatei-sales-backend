<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * @param  CategoryController  $category
     * @param  string  $name
     * @param  int  $price
     * @return int
     */
    public function firstOrCreate($category, $name, $price)
    {
        return Product::firstOrCreate([
            'category_id' => $category->firstOrCreate($name),
            'price' => $price,
        ])['id'];
    }
}

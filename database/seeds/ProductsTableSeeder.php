<?php

use Illuminate\Database\Seeder;
use Infrastructure\Database\Model\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['きゃべつ', '玉ネギ', 'トマト'] as $name) {
            Product::create(['name' => $name]);
        }
    }
}

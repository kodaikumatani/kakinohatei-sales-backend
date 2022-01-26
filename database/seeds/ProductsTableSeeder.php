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
        foreach (['product A', 'product B', 'product C'] as $name) {
            Product::create(['name' => $name]);
        }
    }
}

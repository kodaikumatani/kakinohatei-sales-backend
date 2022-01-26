<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Infrastructure\Database\Model\Store;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(['store A', 'store B', 'store C'] as $name) {
            Store::create(['name' => $name]);
        }
    }
}

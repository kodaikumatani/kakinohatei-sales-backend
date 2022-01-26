<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SalesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProvidersTableSeeder::class);
        $this->call(StoresTableSeeder::class);
    }
}

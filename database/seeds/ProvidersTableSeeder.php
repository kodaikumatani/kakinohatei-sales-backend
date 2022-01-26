<?php

use Illuminate\Database\Seeder;
use Infrastructure\Database\Model\Provider;

class ProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::create([
            'provider_id' => 682,
            'name' => '山田太郎'
        ]);
    }
}

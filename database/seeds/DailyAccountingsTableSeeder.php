<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Infrastructure\Database\Model\DailyAccounting;

class DailyAccountingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $prices = [300,400,500];
        for ($day = 1; $day < 31; $day++) {
            for ($store = 1; $store <= 3; $store++) {
                for ($product = 0; $product < count($prices); $product++) {
                    $quantity = $faker->numberBetween($min=5, $max=20);
                    DailyAccounting::create([
                        'received_at' => '2022-01-'.$day.' 21:10:00',
                        'store_id' => $store,
                        'product_id' => $product + 1,
                        'price' => $prices[$product],
                        'quantity' => $quantity,
                        'store_sum' => $quantity + $faker->numberBetween($min=0, $max=10),
                    ]);
                }
            }
        }
    }
}

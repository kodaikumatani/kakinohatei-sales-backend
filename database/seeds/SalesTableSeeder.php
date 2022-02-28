<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Infrastructure\Database\Model\Sales;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $store = 3;
        $prices = [300,400,500];
        $data = [[0,0,0],[0,0,0],[0,0,0]];
        foreach ([10,11,12,13,14,15,16,17,18,19,20] as $hour){
            for ($i = 0; $i < $store; $i++) {
                for ($j = 0; $j < count($prices); $j++) {
                    $data[$i][$j] += $faker->numberBetween($min=0, $max=5);
                    Sales::create([
                        'received_at' => '2022-01-31 '.$hour.':00:00',
                        'store_id' => $i+1,
                        'recorded_at' => '2022-01-31 '.$hour.':00:00',
                        'product_id' =>$j+1,
                        'price' => $prices[$j],
                        'quantity' =>$data[$i][$j],
                        'store_sum' => $data[$i][$j]
                    ]);
                }
            }
        }
    }
}

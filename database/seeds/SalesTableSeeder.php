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
        
        for ($day=1; $day<=31; $day++) {
            $record = [];
            for($i=0; $i<$store; $i++) {
                $product = [];
                foreach($prices as $price) {
                    $product[] = array($price,0);
                }
                $record[] = $product;
            }
            foreach ([10,11,12,13,14,15,16,17,18,19] as $hour){
                for ($i=0; $i<$store; $i++) {
                    for ($j=0; $j<count($prices); $j++) {
                        $record[$i][$j][1] += $faker->numberBetween($min=0, $max=5);
                        
                        Sales::create([
                            'received_at' => '2022-01-'.$day.' '.$hour.':00:00',
                            'provider_id' => 682,
                            'store_id' => $i+1,
                            'recorded_at' => '2022-01-'.$day.' '.$hour.':00:00',
                            'product_id' =>$j+1,
                            'price' => $record[$i][$j][0],
                            'quantity' =>$record[$i][$j][1],
                            'store_sum' => $record[$i][$j][1]
                        ]);
                    }
                } 
            }
        }
    }
}

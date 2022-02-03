<?php

use Illuminate\Database\Seeder;
use Infrastructure\Database\Model\Accounting;
use Illuminate\Support\Facades\DB;

class AccountingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($day=1; $day<=31; $day++) {
            $date = '2022-01-'.str_pad($day,2,0,STR_PAD_LEFT).' 21:00:00';
            
            $sales = DB::table('sales')
    			->selectRaw('sum(price * quantity) as summary')
    			->where('received_at', $date)
    			->get()[0]
    			->summary;
			
            Accounting::create([
                'received_at' => $date,
                'sales' => $sales
            ]);
        }
    }
}

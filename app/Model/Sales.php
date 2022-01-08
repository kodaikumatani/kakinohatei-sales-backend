<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sales extends Model
{
	private function timeOfLastReceive()
	{
		return $this
			->select('received_at')
			->groupBy('received_at')
			->orderBy('received_at', 'desc')
			->limit(1)
			->get()[0]
			->received_at;
	}
	
	public function daily()
	{
		return $this
			->selectRaw('max(received_at) as received, sum(price * quantity) as sales')
			->where('received_at', $this->timeOfLastReceive())
			->get()[0];
	}
	
	public function monthly()
	{
		$this_monthly_mails = $this
			->selectRaw("max(received_at) as date")
			->groupByRaw("DATE_FORMAT(received_at, '%Y%m%d')")
			->where('received_at', 'like', date('Y-m').'%')
			->get();
		
		$sum = 0;
		foreach($this_monthly_mails as $daily) {
			$sum += $this
				->selectRaw('sum(price * quantity) as sales')
				->where('received_at', $daily->date)
				->get()[0]
				->sales;
		}
		return (object)array('received' => $this->timeOfLastReceive(), 'sales' => $sum);
	}
	
    public function details()
	{
		return $this
			->select(
				'sales.id',
				'recorded_at',
				'stores.name as store',
				'products.name as product',
				'price','quantity',
				'store_sum'
				)
			->join('stores','stores.id','=','sales.store_id')
			->join('products','products.id','=','sales.product_id')
			->where('received_at', $this->timeOfLastReceive())
			->orderBy('store_id')
			->get();
			
	}
}
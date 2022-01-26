<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
	
	public function summary()
	{
		$received_at = $this->timeOfLastReceive();
		$daily = $this
			->selectRaw('sum(price * quantity) as summary')
			->where('received_at', $received_at)
			->get()[0]
			->summary;
		
		$this_month_mails = $this
			->selectRaw("max(received_at) as date")
			->groupByRaw("DATE_FORMAT(received_at, '%Y%m%d')")
			->where('received_at', 'like', substr($received_at,0,7).'%')
			->get();
		
		$monthly = 0;
		foreach($this_month_mails as $mail) {
			$monthly += $this
				->selectRaw('sum(price * quantity) as sales')
				->where('received_at', $mail->date)
				->get()[0]
				->sales;
		}
		return array('received'=>$received_at, 'daily'=>$daily, 'monthly'=>$monthly);
	}
	
	public function chart()
	{
		$data = [];
		$lastReceive = substr($this->timeOfLastReceive(),0,11);
		
		for ($hour=10; $hour<=19; $hour++) {
			$query = $lastReceive.$hour.'%';
			$lastTimeInHour = $this
				->selectRaw('max(received_at) as lastdate')
				->where('received_at', 'like', $query)
				->get()[0]
				->lastdate;
			
			$salesHour = $this
				->selectRaw('sum(price * quantity) as amount')
				->where('received_at', $lastTimeInHour)
				->get()[0]
				->amount;
				
			$data[] = array('time' => $hour, 'amount' => (int)$salesHour);
		}
		return $data;
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
<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
	public function timeOfLastReceive()
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
			->selectRaw('sum(price * quantity) as summary')
			->where('received_at', $this->timeOfLastReceive())
			->get()[0]
			->summary;
	}
	
	public function summary()
	{
		$received_at =  $this->timeOfLastReceive();
		$monthly = DB::table('accountings')
			->where('received_at', 'like', substr($received_at,0,7)."%")
			->sum('sales');
		return array('received'=>$received_at, 'daily'=>$this->daily(), 'monthly'=>$monthly);
	}
	
	public function chart()
	{
		$data = [];
		$lastReceivedDate = substr($this->timeOfLastReceive(),0,11);
		for ($hour=10; $hour<=21; $hour++) {
			$query = $lastReceivedDate.$hour.'%';
			
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
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DailyAccounting;

class Sales extends Model
{
	/**
     * Attributes for multiple assignments
     *
     * @var array
     */
	public function timeOfLastReceive()
	{
		return $this
			->select('received_at')
			->groupBy('received_at')
			->orderBy('received_at', 'desc')
			->limit(1)
			->value('received_at');
	}

	public function summary()
	{
		$monthly = new DailyAccounting();
		$received_at =  $this->timeOfLastReceive();
		$daily = $this
			->selectRaw('sum(price * quantity) as amount')
			->where('received_at', $this->timeOfLastReceive())
			->value('amount');
		return array('received'=>$received_at, 'daily'=>$daily, 'monthly'=>$monthly->monthlyAmount());
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
				->value('lastdate');

			$salesHour = $this
				->selectRaw('sum(price * quantity) as amount')
				->where('received_at', $lastTimeInHour)
				->value('amount');
				
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
				'price',
				'quantity',
				'store_sum')
			->join('stores','stores.id','=','sales.store_id')
			->join('products','products.id','=','sales.product_id')
			->where('received_at', $this->timeOfLastReceive())
			->orderBy('store_id')
			->get();
	}
}
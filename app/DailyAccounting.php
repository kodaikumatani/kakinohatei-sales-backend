<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyAccounting extends Model
{
    /**
     * Attributes for multiple assignments
     *
     * @var array
     */
    private function timeOfLastReceive()
	{
		return $this
			->select('received_at')
			->groupBy('received_at')
			->orderBy('received_at', 'desc')
			->limit(1)
			->value('received_at');
	}
	
	public function monthlyAmount()
    {
        $received_at = $this->timeOfLastReceive();
        return $this
            ->selectRaw('sum(price * quantity) as amount')
            ->where('received_at', 'like', substr($received_at,0,7).'%')
            ->value('amount');
    }
    
    public function monthlyRecord() {
        $received_at = $this->timeOfLastReceive();
        return $this
			->select(
				'daily_accountings.id',
				'received_at',
				'stores.name as store',
				'products.name as product',
				'price',
				'quantity',
				'store_sum')
			->join('stores','stores.id','=','daily_accountings.store_id')
			->join('products','products.id','=','daily_accountings.product_id')
			->where('received_at', 'like', substr($received_at,0,7).'%')
			->orderBy('id')
			->get();
    }
}
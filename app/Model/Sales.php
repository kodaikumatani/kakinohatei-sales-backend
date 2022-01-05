<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sales extends Model
{
	public function daily()
	{
		return $this->selectRaw('max(received_at) as received, sum(price * quantity) as sales')
			->whereRaw('received_at=(select received_at from sales group by received_at order by received_at desc limit 1)')
			->get();
	}
	
    public function details()
	{
		return $this->select('recorded_at','stores.name as store','products.name as product','price','quantity','store_sum')
			->join('stores','stores.id','=','sales.store_id')
			->join('products','products.id','=','sales.product_id')
			->whereRaw('received_at=(select received_at from sales group by received_at order by received_at desc limit 1)')
			->orderBy('store_id')
			->get();
			
	}
}
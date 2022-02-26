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
	
	public function monthlyClosing()
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
            ->select('received_at','store_id','product_id','price','quantity','store_sum')
            ->where('received_at', 'like', substr($received_at,0,7).'%')
            ->get();
    }
}
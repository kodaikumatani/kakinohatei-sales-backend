<?php

namespace Infrastructure\Database\Model;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
	/**
     * Attributes for multiple assignments
     *
     * @var array
     */
	protected $fillable = [
        "received_at",
        "store_id",
        "recorded_at",
        "product_id",
        "price",
        "quantity",
        "store_sum",
    ];
    
    public function dailyClosing()
    {
        $timeOfLastReceive = $this
			->select('received_at')
			->groupBy('received_at')
			->orderBy('received_at', 'desc')
			->limit(1)
			->value('received_at');
			
    	return $this
    		->where('received_at', $timeOfLastReceive)
			->get();
    }
    
    public function doesntExistRecord($message, $storeID, $productID)
    {
    	return $this
    	    ->where([
                'received_at' => $message['received_at'],
                'store_id' => $storeID,
                'recorded_at' => $message['recorded_at'],
                'product_id' => $productID,
                'price' => $message['price'],
                'quantity' => $message['quantity']
            ])->doesntExist();
    }
}
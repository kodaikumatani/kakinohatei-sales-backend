<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Carbon\Carbon;

class LogController extends Controller
{
    /**
     * 売上の小計を計算します
     */
    public function subtotal()
    {
        return Log::select('date_time', 'store', 'product', 'price')
            ->selectRaw('quantity - IFNULL(LAG (quantity, 1)
                OVER (PARTITION BY CAST(date_time AS DATE), store, product, price ORDER BY date_time), 0)
                AS quantity')
            ->selectRaw('store_sum - IFNULL(LAG (store_sum, 1)
                OVER (PARTITION BY CAST(date_time AS DATE), store, product, price ORDER BY date_time), 0)
                AS store_sum')
            ->whereIn('date_time', Log::select('date_time')
                ->distinct()
                ->where('updated_at', '>=', Carbon::now()
                    ->subSecond(600)))
            ->get();
    }

    /**
     * @param  array  $messages
     */
    public function store($messages)
    {
        foreach ($messages as $message) {
            Log::updateOrCreate(
                [
                    'date_time' => $message['date'],
                    'producer_code' => $message['producer_code'],
                    'producer' => $message['producer'],
                    'store' => $message['store'],
                    'product' => $message['product'],
                    'price' => $message['price'],
                ],
                [
                    'quantity' => $message['quantity'],
                    'store_sum' => $message['store_sum'],
                ]
            );
        }
    }
}

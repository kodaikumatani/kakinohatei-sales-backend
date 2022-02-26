<?php

namespace Infrastructure\Database\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Infrastructure\Database\Model\Sales;
use Infrastructure\Database\Model\DailyAccounting;

class DailyAccountingsController extends Controller
{
    public function dailyClosing()
    {
        $sales = new Sales();
        foreach($sales->dailyClosing() as $record) {
            DailyAccounting::create([
                'received_at' => $record['received_at'],
                'store_id' => $record['store_id'],
                'product_id' => $record['product_id'],
                'price' => $record['price'],
                'quantity' => $record['quantity'],
                'store_sum' => $record['store_sum'],
            ]);
        }
    }
}
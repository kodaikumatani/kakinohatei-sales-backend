<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Product;
use App\Models\Sales;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * @return void
     */
    public static function normalizeSalesLog(): void
    {
        foreach(Log::fetchUpdatedSales() as $record) {
            $user_id = User::getUserId($record['producer_code']);
            $store_id = Store::getStoreId($user_id, $record['store']);
            $product_id = Product::getProductId($user_id, $record['product'], $record['price']);
            Sales::query()->updateOrCreate(
                [
                    'date' => date('Y-m-d', strtotime($record['dateTime'])),
                    'hour' => self::roundTime(strtotime($record['dateTime'])),
                    'user_id' => $user_id,
                    'store_id' => $store_id,
                    'product_id' => $product_id
                ],
                [
                    'quantity' => $record['quantity'],
                    'store_total' => $record['store_total'],
                ]
            );
        }
    }

    /**
     * @param $dateTime
     * @return string
     */
    private static function roundTime($dateTime): string
    {
        $minutes = round(date('i', $dateTime) / 60) * 60;
        $time = mktime(date('H', $dateTime), $minutes);
        return date('H',$time);
    }
}

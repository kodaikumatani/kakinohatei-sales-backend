<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Service\ManageMailboxes;
use Google\Exception;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * @return void
     * @throws Exception
     */
    public static function registerSalesLog(): void
    {
        foreach(ManageMailboxes::getMessage() as $message) {
            Log::query()->updateOrCreate(
                [
                    'dateTime' => $message['date'],
                    'producer_code' => $message['producer_code'],
                    'producer' => $message['producer'],
                    'store' => $message['store'],
                    'product' => $message['product'],
                    'price' => $message['price'],
                ],
                [
                    'quantity'=> $message['quantity'],
                    'store_total' => $message['store_total'],
                ]
            );
        }
    }
}

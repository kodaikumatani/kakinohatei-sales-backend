<?php

namespace App\Http\Controllers;

use App\Mail\HourlySalesMail;
use App\Models\Log;
use App\Models\Product;
use App\Models\Sales;
use App\Models\Store;
use App\Models\User;
use App\Service\ManageMailboxes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ImapMailController extends Controller
{
    public static function readByYear(Carbon $date)
    {
        $messages = ManageMailboxes::getMessageByYear($date);
        foreach ($messages as $message) {
            $user_id = User::getUserId($message['producer_code']);
            $store_id = Store::getStoreId($user_id, $message['store']);
            $product_id = Product::getProductId($user_id, $message['product'], $message['price']);
            Sales::query()->updateOrCreate(
                [
                    'date' => $message['date'],
                    'hour' => self::roundTime(strtotime($message['date'])),
                    'user_id' => $user_id,
                    'store_id' => $store_id,
                    'product_id' => $product_id,
                ],
                [
                    'quantity' => $message['quantity'],
                    'store_total' => $message['store_total'],
                ]
            );
        }
    }

    public static function readToday()
    {
        // $date = Carbon::today();
        $date = Carbon::parse('2023-12-28');
        self::save(ManageMailboxes::getMessageByDate($date));
    }

    public static function send()
    {
        Mail::send(new HourlySalesMail);
    }

    private static function roundTime($dateTime): string
    {
        $minutes = round(date('i', $dateTime) / 60) * 60;
        $time = mktime(date('H', $dateTime), $minutes);

        return date('H', $time);
    }

    private static function save($messages)
    {
        foreach ($messages as $message) {
            Log::query()->updateOrCreate(
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

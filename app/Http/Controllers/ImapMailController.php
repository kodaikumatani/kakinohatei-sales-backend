<?php

namespace App\Http\Controllers;

use App\Mail\HourlySalesMail;
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
        $date = Carbon::today();
        $messages = ManageMailboxes::getMessageByDate($date);
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
}

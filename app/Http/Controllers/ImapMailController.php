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
        self::save(ManageMailboxes::getMessageByYear($date));
        self::sales_save(Log::caluclateSubtotal());
    }

    public static function readToday()
    {
        self::save(ManageMailboxes::getMessageByDate(Carbon::today()));
        self::sales_save(Log::caluclateSubtotal());
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

    private static function sales_save($rows)
    {
        foreach ($rows as $row) {
            $user_id = User::getUserId($row['producer_code']);
            $store_id = Store::getStoreId($user_id, $row['store']);
            $product_id = Product::getProductId($user_id, $row['product'], $row['price']);
            Sales::query()->updateOrCreate(
                [
                    'date' => $row['date_time'],
                    'hour' => self::roundTime(strtotime($row['date_time'])),
                    'user_id' => $user_id,
                    'store_id' => $store_id,
                    'product_id' => $product_id,
                ],
                [
                    'quantity' => $row['quantity'],
                    'store_total' => $row['store_sum'],
                ]
            );
        }
    }
}

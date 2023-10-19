<?php

namespace App\Http\Controllers;

use App\Mail\HourlySalesMail;
use App\Models\Log;
use App\Service\ManageMailboxes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ImapMailController extends Controller
{
    public static function readToday()
    {
        $date = Carbon::today();
        $messages = ManageMailboxes::getMessageByDate($date);
        foreach ($messages as $message) {
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
}

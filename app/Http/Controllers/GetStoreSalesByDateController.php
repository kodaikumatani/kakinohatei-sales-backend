<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Carbon\Carbon;

class GetStoreSalesByDateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $date)
    {
        return response()
            ->json(
                ['details' => Sales::findStoreByDate(Carbon::parse($date))],
                200,
                [],
                JSON_UNESCAPED_UNICODE,
            );
    }
}

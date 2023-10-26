<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GetStoreByDateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $date)
    {
        return response()
            ->json(
                ['summary' => Sales::findStoreNameByDate(Carbon::parse($date))],
                200,
                [],
                JSON_UNESCAPED_UNICODE,
            );
    }
}

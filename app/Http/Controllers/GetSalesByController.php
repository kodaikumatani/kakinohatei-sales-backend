<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GetSalesByController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $date)
    {
        return response()
            ->json(
                ['details' => Sales::findBy(Carbon::parse($date), $request->input('store_id', 0))],
                200,
                [],
                JSON_UNESCAPED_UNICODE,
            );
    }
}

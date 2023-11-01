<?php

namespace App\Http\Controllers;

use App\Http\Resources\HourlySalesResource;
use App\Models\Sales;
use Carbon\Carbon;

class GetHourlySalesByDateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $date)
    {
        $hours = Sales::findHourlyByDate(Carbon::parse($date))->groupBy('product');

        return response()->json(
            $hours->keys()->map(function ($item) use ($hours) {
                return [
                    'store' => $item,
                    'details' => HourlySalesResource::collection(
                        $hours[$item],
                    ),
                ];
            }),
            200,
            [],
            JSON_UNESCAPED_UNICODE,
        );
    }
}

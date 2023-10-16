<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\JsonResponse;

class GetSalesDailyController extends Controller
{
    /**
     * Obtain sales data for the most recent month
     */
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'summary' => Sales::fetchDailySales(),
        ]);
    }
}

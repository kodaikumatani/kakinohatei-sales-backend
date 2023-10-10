<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetSalesDateHourlyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param string $date
     * @return JsonResponse
     */
    public function __invoke(Request $request, string $date): JsonResponse
    {
        return response()->json([
            'summary' => Sales::fetchDateHourlySales($date),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}

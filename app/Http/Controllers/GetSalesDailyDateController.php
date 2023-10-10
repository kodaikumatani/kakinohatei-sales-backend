<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetSalesDailyDateRequest;
use App\Models\Sales;
use Illuminate\Http\JsonResponse;

class GetSalesDailyDateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param GetSalesDailyDateRequest $request
     * @param String $date
     * @return JsonResponse
     */
    public function __invoke(GetSalesDailyDateRequest $request, string $date): JsonResponse
    {
        return response()->json([
            'details' => Sales::fetchDailyDateSales($date, $request->input('store_id', 0)),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetDateStoresController extends Controller
{
    /**
     * Obtain sales data for the most recent month
     *
     * @param string $date
     * @return JsonResponse
     */
    public function __invoke(string $date): JsonResponse
    {
        return response()->json([
            'summary' => Sales::fetchDateStores($date),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}

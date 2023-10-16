<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\JsonResponse;

class GetDateStoresController extends Controller
{
    /**
     * Obtain sales data for the most recent month
     */
    public function __invoke(string $date): JsonResponse
    {
        return response()->json([
            'summary' => Sales::fetchDateStores($date),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductSalesResource;
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
        $stores = Sales::findByDate(Carbon::parse($date))->groupBy('store');
        $sales = collect([
            'store' => 'All',
            'details' => ProductSalesResource::collection(
                Sales::findAllStoreByDate(Carbon::parse($date))
            ),
        ]);

        return response()
            ->json(
                $stores->keys()->map(function ($item) use ($stores) {
                    return [
                        'store' => $item,
                        'details' => ProductSalesResource::collection($stores[$item]),
                    ];
                })->prepend($sales),
                200,
                [],
                JSON_UNESCAPED_UNICODE,
            );
    }
}

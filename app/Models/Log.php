<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dateTime',
        'producer_code',
        'producer',
        'store',
        'product',
        'price',
        'quantity',
        'store_total',
    ];

    private static function computeHourlyQuantity($date): array
    {
        return self::query()
            ->select('dateTime', 'producer_code', 'store', 'product', 'price')
            ->selectRaw('quantity -
                COALESCE(
                    (
                        LAG(quantity) OVER (
                            PARTITION BY store, product, price
                            ORDER BY dateTime
                        )
                    ),
                    0
                ) as quantity')
            ->selectRaw('store_total -
                COALESCE(
                    (
                        LAG(store_total) OVER (
                            PARTITION BY store, product, price
                            ORDER BY dateTime
                        )
                    ),
                    0
                ) as store_total')
            ->whereDate('dateTime', $date)
            ->get()
            ->toArray();
    }

    private static function fetchUpdatedSalesDate(): array
    {
        return self::query()
            ->selectRaw('DATE_FORMAT(dateTime, "%Y-%m-%d") AS date')
            ->where('updated_at', '>', date('Y-m-d H:i:s', strtotime('-1 minutes')))
            ->groupBy('date')
            ->get()
            ->toArray();
    }

    public static function fetchUpdatedSales(): array
    {
        $array = [];
        foreach (self::fetchUpdatedSalesDate() as $date) {
            $array = array_merge($array, self::computeHourlyQuantity($date));
        }

        return $array;
    }
}

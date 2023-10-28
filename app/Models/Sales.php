<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'hour',
        'user_id',
        'store_id',
        'product_id',
        'quantity',
        'store_total',
    ];

    /**
     * 指定日の売上がある店舗を取得
     *
     * @param Carbon
     */
    public static function findStoreNameByDate(Carbon $date)
    {
        return self::query()
            ->select('store_id', 'stores.name as name')
            ->whereDate('date', $date)
            ->join('stores', 'stores.id', '=', 'sales.store_id')
            ->groupBy('store_id')
            ->get();
    }

    /**
     * TODO: findByと統合する
     *
     * 指定日の集計を取得
     *
     * @param Carbon
     */
    private static function findByDate(Carbon $date)
    {
        $subQuery = self::query()
            ->select('store_id')
            ->selectRaw('MAX(date) as max_date')
            ->whereDate('date', $date)
            ->groupBy('store_id');

        return self::query()
            ->select('products.name as product', 'products.price')
            ->selectRaw('SUM(quantity) as quantity')
            ->selectRaw('SUM(products.price * quantity) as total')
            ->selectRaw('SUM(store_total) as store_total')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->joinSub($subQuery, 'sub', function ($join) {
                $join
                    ->on('sales.date', '=', 'sub.max_date')
                    ->on('sales.store_id', '=', 'sub.store_id');
            })
            ->groupBy('product_id')
            ->orderBy('product_id')
            ->get();
    }

    /**
     * 指定日の特定店舗の集計を取得
     *
     * @param Carbon
     */
    public static function findBy(Carbon $date, int $store_id)
    {
        if ($store_id == 0) {
            return self::findByDate($date);
        }

        $subQuery = self::query()
            ->select('store_id', 'product_id')
            ->selectRaw('MAX(date) as max_date')
            ->whereDate('date', $date)
            ->groupBy('store_id', 'product_id')
            ->having('store_id', $store_id);

        return self::query()
            ->select('products.name as product', 'products.price', 'quantity', 'store_total')
            ->selectRaw('products.price * quantity as total')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->joinSub($subQuery, 'sub', function ($join) {
                $join
                    ->on('sales.date', '=', 'sub.max_date')
                    ->on('sales.store_id', '=', 'sub.store_id')
                    ->on('sales.product_id', '=', 'sub.product_id');
            })
            ->orderBy('products.id')
            ->get();
    }

    /**
     * 指定日の店舗売上を取得
     *
     * @param Carbon
     */
    public static function findStoreByDate(Carbon $date)
    {
        $subQuery = self::query()
            ->select('store_id')
            ->selectRaw('MAX(date) as max_date')
            ->whereDate('date', $date)
            ->groupBy('store_id');

        return self::query()
            ->select('stores.name')
            ->selectRaw('SUM(products.price * quantity) as value')
            ->join('stores', 'stores.id', '=', 'sales.store_id')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->joinSub($subQuery, 'sub', function ($join) {
                $join
                    ->on('sales.store_id', '=', 'sub.store_id')
                    ->on('sales.date', '=', 'sub.max_date');
            })
            ->withCasts([
                'value' => 'integer',
            ])
            ->groupByRaw('sales.store_id')
            ->get();
    }

    /**
     * 指定日の商品ごとの売上を取得
     *
     * @param Carbon
     */
    public static function findProductByDate(Carbon $date)
    {
        $subQuery = self::query()
            ->select('store_id')
            ->selectRaw('MAX(date) as max_date')
            ->whereDate('date', $date)
            ->groupBy('store_id');

        return self::query()
            ->select('products.name')
            ->selectRaw('SUM(products.price * quantity) as value')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->joinSub($subQuery, 'sub', function ($join) {
                $join
                    ->on('sales.date', '=', 'sub.max_date')
                    ->on('sales.store_id', '=', 'sub.store_id');
            })
            ->withCasts([
                'value' => 'integer',
            ])
            ->groupBy('products.name')
            ->get();
    }

    /**
     * 指定日の時間ごとの売上を取得
     *
     * @param Carbon
     */
    public static function findHourlyByDate(Carbon $date)
    {
        $subQueryA = self::query()
            ->select('hour', 'store_id', 'product_id')
            ->selectRaw('SUM(products.price * quantity) as value')
            ->selectRaw('ROW_NUMBER() OVER(PARTITION BY store_id, product_id ORDER BY hour ASC) as num')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->whereDate('date', $date)
            ->groupBy('hour', 'store_id', 'product_id');

        $subQueryB = self::query()
            ->select('hour', 'store_id', 'product_id')
            ->selectRaw('SUM(products.price * quantity) as value')
            ->selectRaw('ROW_NUMBER() OVER(PARTITION BY store_id, product_id ORDER BY hour ASC) + 1 as num')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->whereDate('date', $date)
            ->groupBy('hour', 'store_id', 'product_id');

        return self::query()
            ->selectRaw('A.hour, SUM(A.value - IFNULL(B.value, 0)) as value')
            ->fromSub($subQueryA, 'A')
            ->leftJoinSub($subQueryB, 'B', function ($join) {
                $join->on('A.num', '=', 'B.num')
                    ->on('A.store_id', '=', 'B.store_id')
                    ->on('A.product_id', '=', 'B.product_id');
            })
            ->withCasts([
                'value' => 'integer',
            ])
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
    }
}

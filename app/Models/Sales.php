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
        'store_id',
        'product_id',
        'quantity',
        'store_sum',
    ];

    /**
     * 指定日の集計を取得
     *
     * @param Carbon
     */
    public static function findAllStoreByDate(Carbon $date)
    {
        return self::query()
            ->select('categories.name AS product', 'products.price')
            ->selectRaw('SUM(quantity) AS quantity')
            ->selectRaw('SUM(products.price * quantity) AS total')
            ->selectRaw('SUM(store_sum) AS store_total')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->whereDate('date', $date)
            ->groupBy('products.id')
            ->orderBy('categories.id')
            ->orderBy('products.id')
            ->withCasts([
                'quantity' => 'integer',
                'total' => 'integer',
                'store_total' => 'integer',
            ])
            ->get();
    }

    /**
     * 指定日の特定店舗の集計を取得
     *
     * @param Carbon
     */
    public static function findByDate(Carbon $date)
    {
        return self::query()
            ->select('stores.name AS store', 'categories.name AS product', 'products.price')
            ->selectRaw('SUM(quantity) AS quantity')
            ->selectRaw('SUM(products.price * quantity) AS total')
            ->selectRaw('SUM(store_sum) AS store_total')
            ->join('stores', 'stores.id', '=', 'sales.store_id')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->whereDate('date', $date)
            ->groupBy('stores.id', 'products.id')
            ->orderBy('stores.id')
            ->orderBy('categories.id')
            ->orderBy('products.id')
            ->withCasts([
                'quantity' => 'integer',
                'total' => 'integer',
                'store_total' => 'integer',
            ])
            ->get();
    }

    /**
     * 指定日の店舗売上を取得
     *
     * @param Carbon
     */
    public static function findStoreByDate(Carbon $date)
    {
        return self::query()
            ->select('stores.name')
            ->selectRaw('SUM(products.price * quantity) AS value')
            ->join('stores', 'stores.id', '=', 'sales.store_id')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->whereDate('date', $date)
            ->groupBy('stores.id')
            ->orderBy('stores.id')
            ->withCasts([
                'value' => 'integer',
            ])
            ->get();
    }

    /**
     * 指定日の商品ごとの売上を取得
     *
     * @param Carbon
     */
    public static function findProductByDate(Carbon $date)
    {
        return self::query()
            ->select('categories.name')
            ->selectRaw('SUM(products.price * quantity) as value')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->whereDate('date', $date)
            ->groupBy('categories.id')
            ->orderBy('categories.id')
            ->withCasts([
                'value' => 'integer',
            ])
            ->get();
    }

    /**
     * 指定日の時間ごとの売上を取得
     *
     * @param Carbon
     */
    public static function findHourlyByDate(Carbon $date)
    {
        return self::query()
            ->select('hour', 'categories.name AS product')
            ->selectRaw('SUM(quantity) AS value')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->whereDate('date', $date)
            ->groupBy('hour', 'categories.id')
            ->orderBy('hour')
            ->orderBy('categories.id')
            ->withCasts([
                'value' => 'integer',
            ])
            ->get();
    }
}

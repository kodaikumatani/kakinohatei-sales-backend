<?php

namespace App\Models;

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
     * The attributes that are mass assignable.
     *
     * @param $date
     * @return Collection
     */
    public static function fetchDateStores($date)
    {
        return self::query()
            ->select('store_id', 'stores.name as name')
            ->where('date', $date)
            ->join('stores', 'stores.id', '=', 'sales.store_id')
            ->groupBy('store_id', 'name')
            ->withCasts([
                'store_id' => 'integer',
            ])->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return Collection
     */
    public static function fetchDailySales()
    {
        return self::query()
            ->select('date')
            ->selectRaw('SUM(products.price * quantity) as value')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->groupBy('date')
            ->withCasts([
                'value' => 'integer',
            ])->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param $date
     * @param $id
     * @return Collection
     */
    public static function fetchDailyDateSales($date, $id)
    {
        return self::query()
            ->select('products.name as product', 'products.price')
            ->selectRaw('SUM(quantity) as quantity')
            ->selectRaw('SUM(store_total) as store_total')
            ->selectRaw('SUM(products.price * quantity) as total')
            ->where('date', $date)
            ->whereRaw("CASE WHEN ? = 0 THEN TRUE ELSE store_id = ? END", [$id, $id])
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->groupBy('product','price')
            ->withCasts([
                'quantity' => 'integer',
                'total' => 'integer',
            ])->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param $date
     * @return Collection
     */
    public static function fetchDailyDateStoresSales($date)
    {
        return self::query()
            ->select('stores.name')
            ->selectRaw('SUM(products.price * quantity) as value')
            ->where('sales.date', $date)
            ->join('stores', 'stores.id', '=', 'sales.store_id')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->groupBy('stores.name')
            ->withCasts([
                'value' => 'integer',
            ])->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param $date
     * @return Collection
     */
    public static function fetchDailyDateProductsSales($date)
    {
        return self::query()
            ->select('products.name')
            ->selectRaw('SUM(products.price * quantity) as value')
            ->where('sales.date', $date)
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->groupBy('products.name')
            ->withCasts([
                'value' => 'integer',
            ])->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param $date
     * @return Collection
     */
    public static function fetchDateHourlySales($date)
    {
        return self::query()
            ->select('hour')
            ->selectRaw('SUM(products.price * quantity) as value')
            ->where('sales.date', $date)
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->groupBy('hour')
            ->withCasts([
                'hour' => 'integer',
                'value' => 'integer',
            ])->get();
    }
}

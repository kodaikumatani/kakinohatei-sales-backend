<?php

namespace App\Models;

use Carbon\Carbon;
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
        'date_time',
        'producer_code',
        'producer',
        'store',
        'product',
        'price',
        'quantity',
        'store_sum',
    ];

    /**
     * 売上の時間計を取得する
     */
    public static function caluclateSubtotal()
    {
        $subQuery = self::query()
            ->select('date_time', 'producer_code', 'store', 'product', 'price', 'quantity', 'store_sum', 'updated_at')
            ->selectRaw('CAST(date_time AS DATE) date')
            ->selectRaw('ROW_NUMBER() OVER(PARTITION BY CAST(date_time AS DATE), store, product, price ORDER BY date_time) num')
            ->selectRaw('ROW_NUMBER() OVER(PARTITION BY CAST(date_time AS DATE), store, product, price ORDER BY date_time) + 1 shift_num');

        return self::query()
            ->select('main.date_time', 'main.producer_code', 'main.store', 'main.product', 'main.price')
            ->selectRaw('main.quantity - IFNULL(shift.quantity, 0) as quantity')
            ->selectRaw('main.store_sum - IFNULL(shift.store_sum, 0) as store_sum')
            ->fromSub($subQuery, 'main')
            ->leftJoinSub($subQuery, 'shift', function ($join) {
                $join->on('main.num', '=', 'shift.shift_num')
                    ->on('main.date', '=', 'shift.date')
                    ->on('main.store', '=', 'shift.store')
                    ->on('main.product', '=', 'shift.product')
                    ->on('main.price', '=', 'shift.price');
            })
            ->where('main.updated_at', '>=', Carbon::now()->subSecond(300))
            ->get();
    }
}

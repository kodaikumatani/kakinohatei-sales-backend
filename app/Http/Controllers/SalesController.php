<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Carbon\Carbon;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $rows
     * @param  StoreController  $store
     * @param  CategoryController  $category
     * @param  ProductController  $product
     */
    public function store($rows, $store, $category, $product)
    {
        foreach ($rows as $row) {
            Sales::updateOrCreate(
                [
                    'date' => $row['date_time'],
                    'hour' => $this->roundTime($row['date_time']),
                    'store_id' => $store->firstOrCreate($row['store']),
                    'product_id' => $product->firstOrCreate($category, $row['product'], $row['price']),
                ],
                [
                    'quantity' => $row['quantity'],
                    'store_sum' => $row['store_sum'],
                ]
            );
        }
    }

    /**
     * @param  Carbon  $dateTime
     * @return int
     */
    private static function roundTime($dateTime)
    {
        $minutes = round($dateTime->minute / 60) * 60;
        $time = mktime($dateTime->hour, $minutes);

        return date('H', $time);
    }
}

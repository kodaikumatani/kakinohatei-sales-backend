<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sales;
use App\DailyAccounting;

class DailyAccountingsController extends Controller
{
    public function index(DailyAccounting $accounting)
    {
	    return response()->json([
	        'monthly' => $accounting->monthlyRecord(),
	    ]);
    }
}
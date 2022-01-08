<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Sales;

class SalesController extends Controller
{
    public function index(Sales $sales)
    {
        $daily = $sales->daily();
        $monthly = $sales->monthly();
        $details = $sales->details();
	    return response()->json([
	        'daily' => $daily,
	        'monthly' => $monthly,
	        'details' => $details
	        ]);
    }
}

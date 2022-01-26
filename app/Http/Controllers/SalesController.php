<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sales;

class SalesController extends Controller
{
    public function index(Sales $sales)
    {
        $summary = $sales->summary();
        $chart = $sales->chart();
        $details = $sales->details();
	    return response()->json([
	        'summary' => $summary,
	        'chart' => $chart,
	        'details' => $details
	    ]);
    }
}

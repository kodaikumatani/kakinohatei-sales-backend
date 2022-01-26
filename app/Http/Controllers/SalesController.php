<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sales;

class SalesController extends Controller
{
    public function index(Sales $sales)
    {
	    return response()->json([
	        'summary' => $sales->summary(),
	        'chart' => $sales->chart(),
	        'details' => $sales->details()
	    ]);
    }
}

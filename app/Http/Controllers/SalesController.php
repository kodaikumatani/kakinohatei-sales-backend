<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Sales;

class SalesController extends Controller
{
    public function index(Sales $sales)
    {
        $daily = $sales->daily();
        $details = $sales->details();
	    return response()->json(['details' => $details, 'daily' => $daily]);
    }
}

<?php

namespace Infrastructure\Database\Controller;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Infrastructure\Database\Model\Accounting;
use App\Sales;

class AccountingsController extends Controller
{
    public function dailyClosing()
    {
        $sales = new Sales();
        Accounting::create([
            'received_at' => $sales->timeOfLastReceive(),
            'sales' => $sales->daily()
        ]);
    }
}
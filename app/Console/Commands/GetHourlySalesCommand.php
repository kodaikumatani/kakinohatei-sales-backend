<?php

namespace App\Console\Commands;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StoreController;
use App\Service\ManageMailboxes;
use Carbon\Carbon;
use Google\Exception;
use Illuminate\Console\Command;

class GetHourlySalesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:read {year?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read a message in UNREAD box';

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle(LogController $log, SalesController $sales): void
    {
        $year = $this->argument('year');
        if ($year != null) {
            $log->store(ManageMailboxes::getMessageByYear(Carbon::create($year)));
            $sales->store($log->subtotal(), new StoreController, new CategoryController, new ProductController);
        } else {
            $log->store(ManageMailboxes::getMessageByDate(Carbon::today()));
            $sales->store($log->subtotal(), new StoreController, new CategoryController, new ProductController);
        }
    }
}

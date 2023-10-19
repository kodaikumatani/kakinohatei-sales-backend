<?php

namespace App\Console\Commands;

use App\Http\Controllers\ImapMailController;
use App\Http\Controllers\SalesController;
use Google\Exception;
use Illuminate\Console\Command;

class GetHourlySalesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:read';

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
    public function handle(): void
    {
        ImapMailController::readToday();
        SalesController::normalizeSalesLog();
    }
}

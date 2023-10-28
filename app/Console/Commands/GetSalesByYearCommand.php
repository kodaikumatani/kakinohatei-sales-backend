<?php

namespace App\Console\Commands;

use App\Http\Controllers\ImapMailController;
use Illuminate\Console\Command;
use Carbon\Carbon;

class GetSalesByYearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:read {year}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $year = $this->argument('year');
        ImapMailController::readByYear(Carbon::create($year));
    }
}

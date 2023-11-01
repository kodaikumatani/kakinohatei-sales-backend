<?php

namespace App\Console\Commands;

use App\Http\Controllers\ImapMailController;
use Google\Exception;
use Illuminate\Console\Command;

use Carbon\Carbon;

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
    public function handle(): void
    {
        $year = $this->argument('year');
        if ($year == null) {
            ImapMailController::readToday();
        }

        if (is_int($year)) {
            ImapMailController::readByYear(Carbon::create($year));
        }
    }
}

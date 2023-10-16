<?php

namespace App\Console\Commands;

use App\Service\SalesRequest;
use Google\Exception;
use Illuminate\Console\Command;

class SalesRequestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle(): void
    {
        SalesRequest::sendMessage();
    }
}

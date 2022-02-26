<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\SendEmail;

class SendBlankEmail extends Command
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
    protected $description = 'Send a blank e-mail to JAinaba.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(SendEmail $client)
    {
        $client->toJAinaba();
    }
}

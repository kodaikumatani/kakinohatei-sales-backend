<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Infrastructure\Database\Controller\DailyAccountingsController;

class DailyClosing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:dailyclosing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store daily closing in Accounting.';

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
    public function handle(DailyAccountingsController $controller)
    {
        $controller->dailyClosing();
    }
}

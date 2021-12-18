<?php

namespace Infrastructure\Database\Controller;

use App\Service\ManageMailboxes;

class SalesTableController
{
    public function saveSalesData()
    {
        $mailclient = new ManageMailboxes();
        foreach($mailclient->getMessage() as $message) {
            print_r($message);
        }
    }
}
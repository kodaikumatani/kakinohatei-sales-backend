<?php

namespace App\Service;

use Carbon\Carbon;
use Webklex\IMAP\Facades\Client;

class ManageMailboxes
{
    public static function getMessageByYear(Carbon $date)
    {
        $client = Client::account('default');
        $client->connect();

        $folder = $client->getFolderByName('INBOX');

        $messages = $folder->messages()
            ->from(config('mail.ja_inaba.from.address'))
            ->whereBefore($date->endOfYear())
            ->WhereSince($date->startOfYear())
            ->setFetchOrder('asc')
            ->get();

        $record = [];
        foreach ($messages as $message) {
            $record[] = MailAnalysis::regex($date, $message->getTextBody());
        }

        return array_reduce($record, 'array_merge', []);
    }

    public static function getMessageByDate($date)
    {
        $client = Client::account('default');
        $client->connect();

        $folder = $client->getFolderByName('INBOX');

        $messages = $folder->messages()
            ->from(config('mail.ja_inaba.from.address'))
            ->whereOn($date)
            ->setFetchOrder('asc')
            ->limit(10)
            ->get();

        $record = [];
        foreach ($messages as $message) {
            $record[] = MailAnalysis::regex($date, $message->getTextBody());
            $message->setFlag('SEEN');
        }

        return array_reduce($record, 'array_merge', []);
    }
}

<?php

namespace App\Service;

use Google\Exception;
use Google_Service_Gmail;
use Google_Service_Gmail_ModifyMessageRequest;

class ManageMailboxes
{
    /**
     * Returns the retrieved mail content.
     *
     * @return array
     * @throws Exception
     */
    public static function getMessage(): array
    {
        // Get the API client and construct the service object.
        $client = GoogleClient::getClient();
        $service = new Google_Service_Gmail($client);
        $mods = new Google_Service_Gmail_ModifyMessageRequest();

        $user = 'me';
        $optParams = [
            'maxResults' => '10',
            'labelIds' => 'UNREAD',
            'q' => "subject:JA鳥取いなば直売所売上速報　from:".config('mail.from.address')
        ];
        // Get a list of emails that match the conditions.
        $data = [];
        $messages = $service->users_messages->listUsersMessages($user,$optParams);
        foreach ((array)$messages->getMessages() as $message)   {
            $message_id = $message->getID();
            $message_contents = $service->users_messages->get($user,$message_id);
            $internal_date = substr($message_contents->getInternalDate(),0,-3);
            $encode_bytes = $message_contents->getPayload()->getBody()->getData();
            $trance_encode_bytes = str_replace(array('-', '_'),array('+', '/'),$encode_bytes);
            $decoded_bytes = base64_decode($trance_encode_bytes);
            $data = array_merge($data, MailAnalysis::regex($internal_date,$decoded_bytes));
              // Remove the unread label.
            $mods->setRemoveLabelIds(['UNREAD']);
            $service->users_messages->modify('me', $message_id, $mods);
        }
        return array_filter($data);
    }
}

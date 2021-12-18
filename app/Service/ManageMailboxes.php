<?php

namespace App\Service;

use Google_Service_Gmail;
use Google_Service_Gmail_ModifyMessageRequest;

/**
* Returns an authorized API client.
* @return Google_Client the authorized client object
*/
class ManageMailboxes extends GoogleClient
{
    public function getMessage()
    {
        // Get the API client and construct the service object.
        $client = $this->getClient();
        $service = new Google_Service_Gmail($client);
        $mods = new Google_Service_Gmail_ModifyMessageRequest();

        $user = 'me';
        $optParams = [
            'maxResults' => '10',
            'labelIds' => 'UNREAD',
            'q' => 'from:tyokuhan@jainaba.com',
        ];
        // Get a list of emails that match the conditions.
        $messages = $service->users_messages->listUsersMessages($user, $optParams);
        $mails = [];
        foreach ($messages->getMessages() as $message)   {
            $message_id = $message->getID();
            $message_contents = $service->users_messages->get($user, $message_id);
            $encode_bytes = $message_contents->getPayload()->getBody()->getData();
            $trance_encode_bytes = str_replace(array('-', '_'), array('+', '/'),  $encode_bytes);
            $decoded_bytes = base64_decode($trance_encode_bytes);
            $mails[] = $decoded_bytes;

            // Remove the unread label.
            $mods->setRemoveLabelIds(['UNREAD']);
            //$service->users_messages->modify('me', $message_id, $mods);
        }
        return $this->castArray($mails);
    }

    private function castArray($messages)
    {
        $data = [];
        foreach ($messages as $message) {
            // Divide sales-info by store.
            $message = explode("\n【", $message)[0];
            $split_str = '-----------------------------------------------------------------------';
            $split_message = explode($split_str, $message);
            $sales_store = array_slice($split_message,1);
            // Get proctor_id and proctor name
            $split_header = explode("\n",$split_message[0]);
            $provider_id = str_replace(['生産者コード:',"\r"],'',$split_header[0]);
            $provider = str_replace(" 様\r",'',$split_header[1]);

            foreach ($sales_store as $str) {
                // Divide a newline character
                $store_info = explode("\n", $str);
                // Keep decent form of list
                array_shift($store_info);
                array_pop($store_info);
                $sales_info = array_slice($store_info,1);
                // Get store name and record date
                $store = explode(' :',$store_info[0])[0];
                $record_date = $this->editDate(explode(':',$store_info[0])[1]);

                foreach ($sales_info as $str)   {
                    $text = explode(' ', explode("\r",$str)[0]);
                    $sales_product = array_values(array_filter($text));
                    // Get Sales infomation
                    $product = str_replace('（鳥取県産）','', $sales_product[0]);
                    $price = str_replace('円','', $sales_product[1]);
                    $quantity = str_replace('個','',$sales_product[2]);
                    if (isset($sales_product[4])) {
                        $total = str_replace('個)','',$sales_product[4]);
                    } else {
                        $total = $quantity;
                    }
                    
                    $data[] = [
                        'provider_id' => $provider_id,
                        'provider' => $provider,
                        'store' => $store,
                        'record_date' => $record_date,
                        'product' => $product,
                        'price' => $price,
                        'quantity' => $quantity,
                        'total' => $total
                    ];
                }
            }
        }
        return $data;
    }

    private function editDate($text)
    {
        $text = str_replace(' (', date('Y').'-',$text);
        $text = str_replace('月', '-',$text);
        $text = str_replace('日', ' ',$text);
        $text = str_replace('時', ':',$text);
        $text = str_replace('分', ':',$text);
        $text = str_replace("現在)\r", '00',$text);
        return $text;
    }  
}

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
            'q' => "subject:JA鳥取いなば直売所売上速報 from:".config('mail.to.address')
        ];
        // Get a list of emails that match the conditions.
        $messages = $service->users_messages->listUsersMessages($user,$optParams);
        $mails = [];
        foreach ($messages->getMessages() as $message)   {
            $message_id = $message->getID();
            $message_contents = $service->users_messages->get($user,$message_id);
            $internal_date = substr($message_contents->getInternalDate(),0,-3);
            $received_at = date('Y-m-d H:i:s',$internal_date);
            $encode_bytes = $message_contents->getPayload()->getBody()->getData();
            $trance_encode_bytes = str_replace(array('-', '_'),array('+', '/'),$encode_bytes);
            $decoded_bytes = base64_decode($trance_encode_bytes);
            $mails = array_merge($mails,$this->castToArray($received_at,$decoded_bytes));
            // Remove the unread label.
            $mods->setRemoveLabelIds(['UNREAD']);
            $service->users_messages->modify('me', $message_id, $mods);
        }
        return $mails;
    }

    private function castToArray($received_at,$message)
    {
        $data = [];
        $split = "/構成比\r\n-+\r\n|\n=+\r\n|\n\r\n【|】 【|】\r\n\r\n=+\r\n\r\n/";
        $split_message = preg_split($split,$message);
        
        if(strpos($split_message[1],'売上データはありません。') !== false) {
            return [NULL];
        } else {
            // Get proctor_id and proctor name
            $split_header = preg_split("/\r\n/",$split_message[0]);
            $provider_id = str_replace('生産者コード:','',$split_header[0]);
            $provider = str_replace(" 様\r",'',$split_header[1]);
            // Divide sales-info by store.
            $sales_store = preg_split("/\n-+\r\n/", $split_message[2]);
    
            foreach ($sales_store as $str) {
                // Divide a newline character
                $store_info = preg_split("/現在\)\r\n/",$str);
                // Get store name and record date
                $store_record = preg_split('/\s:\s/',$store_info[0]);
                $store = $store_record[0];
                $recorded_at = $this->editDate($received_at,$store_record[1]);
                $product_info = preg_split("/\n/", $store_info[1]);
    
                foreach ($product_info as $str)   {
                    // Get Sales infomation
                    $sales_product = preg_split("/\s+/",$str);
                    $product = str_replace('（鳥取県産）','',$sales_product[1]);
                    $price = str_replace('円','',$sales_product[2]);
                    $quantity = str_replace('個','',$sales_product[3]);
                    if (isset($sales_product[5])) {
                        $store_sum = str_replace('個)','',$sales_product[5]);
                    } else {
                        $store_sum = $quantity;
                    }
                    
                    $data[] = [
                        'received_at' => $received_at,
                        'provider_id' => $provider_id,
                        'provider' => $provider,
                        'store' => $store,
                        'recorded_at' => $recorded_at,
                        'product' => $product,
                        'price' => $price,
                        'quantity' => $quantity,
                        'store_sum' => $store_sum
                    ];
                }
            }
            return $data;
        }
    }

    private function editDate($received_at,$text)
    {
        $year = date('Y',strtotime($received_at));
        $text = str_replace('(', $year.'-',$text);
        $text = str_replace('月', '-',$text);
        $text = str_replace('日', ' ',$text);
        $text = str_replace('時', ':',$text);
        $text = str_replace('分', ':00',$text);
        return $text;
    }  
}

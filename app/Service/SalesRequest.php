<?php

namespace App\Service;

use Google\Exception;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;

class SalesRequest
{

    /**
     *
     * @throws Exception
     */
    public static function sendMessage(): void
    {
        // Get the API client and construct the service object.
        $client = GoogleClient::getClient();
        $service = new Google_Service_Gmail($client);

        $strSubject = config('app.name') .":".date('M d, Y h:i:s A');
        $strRawMessage = "To: <".config('mail.to.address').">\r\n";
        $strRawMessage .= 'Subject: =?utf-8?B?'.base64_encode($strSubject)."?=\r\n";
        $strRawMessage .= "MIME-Version: 1.0\r\n";
        $strRawMessage .= "Content-Type: text/html; charset=utf-8\r\n";
        $strRawMessage .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
        $strRawMessage .= "This message is sent automatically by the application.\r\n";

        // The message needs to be encoded in Base64URL.
        $mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
        $msg = new Google_Service_Gmail_Message();
        $msg->setRaw($mime);

        //The special value **me** can be used to indicate the authenticated user.
        $service->users_messages->send("me", $msg);
    }
}

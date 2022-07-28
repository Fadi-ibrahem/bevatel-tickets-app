<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GetMailboxMessageService
{
    public function getMessage()
    {
        // Get A Specific Inbox ID Request
        $response = Http::get('https://mailtrap.io/api/v1/companies?api_token=' . env('MAILTRAP_API_TOKEN'));

        // Select The Inbox ID From Response Data
        $inboxID = $response->json()[0]['inboxes'][0]['id'];

        // Get All Messages For A Specific Inbox
        $response = Http::get('https://mailtrap.io/api/v1/inboxes/' . $inboxID . '/messages?api_token=' . env('MAILTRAP_API_TOKEN'));

        // Convert Response To A Readable Array
        $response = $response->json();

        // An Array To Hold All Unread Messages
        $unreadMessages = [];

        // Loop Through All Messages, Then Select Unread Messages Only
        foreach($response as $message) {
            if($message['is_read']) $unreadMessages[] = $message;
        }

        // Select Random Message From The Email Box
        $message = $unreadMessages[mt_rand(0, count($unreadMessages)-1)];

        // Required Data To Submit A Ticket
        $messageSubject     = $message['subject'];
        $messageFromEmail   = $message['from_email'];
        $messageToEmail     = $message['to_email'];

        // Message Content Stored In A txt File On Mailtrap Server, So We're Going To Visit This txt File URL (Path)
        $messageContentUrl = 'https://mailtrap.io' . $message['txt_path'] . '?api_token=' . env('MAILTRAP_API_TOKEN');

        // Get The Content From The txt File
        $messageContent = file_get_contents($messageContentUrl);

        // The Final Data To Be Stored As A New Ticket Into The Database
        $data = [
            'email'     => $messageFromEmail,
            'subject'   => $messageSubject,
            'content'   => $messageContent,
        ];

        return $data;
    }
}

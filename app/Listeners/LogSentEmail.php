<?php

namespace App\Listeners;

use App\Email;
use App\EmailAttachment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class LogSentEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageSending  $event
     * @return void
     */
    public function handle(MessageSending $event)
    {
        $message = $event->message;
        $children = $message->getChildren();
        $attachments = array_filter($children, function($child) {
            return get_class($child) == 'Swift_Attachment';
        });

        $email = Email::create([
            'to' => !$message->getHeaders()->get('To') ? null : $message->getHeaders()->get('To')->getFieldBody(),
            'bcc' => !$message->getHeaders()->get('Bcc') ? null : $message->getHeaders()->get('Bcc')->getFieldBody(),
            'subject' => $message->getHeaders()->get('Subject')->getFieldBody(),
            'body' => $message->getBody()
        ]);
    }
}

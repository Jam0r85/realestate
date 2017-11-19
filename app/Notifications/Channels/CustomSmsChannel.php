<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Nexmo\Laravel\Facade\Nexmo;

class CustomSmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toCustomSms($notifiable);

        return Nexmo::message()->send([
            'to' => $notifiable->phone_number,
            'from' => env('NEXMO_FROM'),
            'text' => $message->content,
            'status-report-req' => 1,
        ]);
        
    }
}
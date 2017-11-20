<?php

namespace App\Listeners;

use App\Notifications\UserSmsMessage;
use App\SmsHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class LogSmsNotification
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
     * @param  NotificationSent  $event
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        $channel = $event->channel;
        $response = $event->response;
        $notifiable = $event->notifiable;

        if ($channel == "App\Notifications\Channels\CustomSmsChannel") {

            $messages = $response['messages'];
            
            SmsHistory::create([
                'owner_id' => Auth::check() ? Auth::user()->id : null,
                'user_id' => $notifiable->id,
                'phone_number' => $response['to'],
                'body' => $response['text'],
                'messages' => $messages
            ]);
        }
    }
}
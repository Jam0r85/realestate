<?php

namespace App\Notifications;

use App\Notifications\Channels\CustomSmsChannel;
use App\Notifications\Messages\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class UserSmsMessage extends Notification
{
    use Queueable;

    /**
     * The message we are sending to the user.
     * 
     * @var string
     */
    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['nexmo'];
        return [CustomSmsChannel::class];
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toCustomSms($notifiable)
    {
        return (new SmsMessage)
            ->content($this->message)
            ->unicode();
    }
}

<?php

namespace App\Notifications;

use App\SmsHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SmsMessageInboundStaffNotification extends Notification
{
    use Queueable;

    /**
     * The message.
     * 
     * @var \App\SmsHistory
     */
    public $message;

    /**
     * Create a new notification instance.
     *
     * @param  \App\SmsHistory  $message
     * @return void
     */
    public function __construct(SmsHistory $message)
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
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'text' => $this->message->body,
            'user' => $this->message->user->present()->fullName
        ];
    }
}

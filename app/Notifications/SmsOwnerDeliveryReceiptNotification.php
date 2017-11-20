<?php

namespace App\Notifications;

use App\SmsHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SmsOwnerDeliveryReceiptNotification extends Notification
{
    use Queueable;

    /**
     * The message we are using.
     * 
     * @var \App\SmsHistory;
     */
    public $message;

    /**
     * Create a new notification instance.
     *
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
            'status' => $this->message->status()
        ];
    }
}

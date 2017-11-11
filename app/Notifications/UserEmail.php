<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserEmail extends Notification
{
    use Queueable;

    /**
     * The subject of the e-mail.
     * 
     * @var string
     */
    public $subject;

    /**
     * The message of the e-mail.
     * 
     * @var string
     */
    public $message;

    /**
     * Create a new notification instance.
     *
     * @param  string $subject
     * @param  string $message
     * @return void
     */
    public function __construct($subject, $message)
    {
        $this->subject = $subject;
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->markdown('email-templates.user-email-message', ['message' => $this->message]);
    }
}

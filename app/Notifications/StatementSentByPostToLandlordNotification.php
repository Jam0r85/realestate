<?php

namespace App\Notifications;

use App\Statement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatementSentByPostToLandlordNotification extends Notification
{
    use Queueable;

    /**
     * The statement we are sending.
     * 
     * @var \App\Statement
     */
    public $statement;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
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
            ->subject('Your Rental Statement')
            ->markdown('email-templates.statement-by-post', [
                'statement' => $this->statement
            ]);
    }
}

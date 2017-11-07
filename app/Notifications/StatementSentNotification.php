<?php

namespace App\Notifications;

use App\Mail\StatementByEmail;
use App\Mail\StatementByPost;
use App\Statement;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class StatementSentNotification extends Notification
{
    use Queueable;

    /**
     * The statement we are sending.
     * 
     * @var \App\Statement
     */
    public $statement;

    /**
     * The user we are sending the statement to.
     * 
     * @var \App\Statement
     */
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Statement $statement, User $user)
    {
        $this->statement = $statement;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Statement to be sent by post, send the basic e-mail.
        if ($this->statement->send_by == 'post') {
            return (new StatementByPost($this->statement))
                ->to($this->user->email);
        }

        // Statement to be sent by email, send the email with statement, invoice and expenses attached.
        if ($this->statement->send_by == 'email') {
            return (new StatementByEmail($this->statement))
                ->to($this->user->email);
        }
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
            'statement_id' => $this->statement->id,
            'send_by' => $this->statement->send_by
        ];
    }
}

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
        if ($this->statement->send_by == 'post') {
            $method = 'post';
        } elseif ($this->statement->send_by == 'email') {
            $method = 'email';
        }
        
        if ($method == 'email') {
            $statementToBeAttached = app('\App\Http\Controllers\DownloadController')->statement($this->statement->id, 'raw');

            $email = new MailMessage();
            $email->subject('Your Rental Statement');
            $email->markdown('email-templates.statement-by-email', ['statement' => $this->statement]);
            $email->attachData($statementToBeAttached, $this->statement->property->short_name . ' Statement.pdf');

            if (count($this->statement->expenses)) {
                // Loop through the expenses
                foreach ($this->statement->expenses as $expense) {
                    // Check whether the expense has an invoice
                    if (count($expense->documents)) {
                        foreach ($expense->documents as $invoice) {
                            $email->attach(
                                Storage::url($invoice->path), [
                                    'as' => $invoice->name . '.' . $invoice->extension
                                ]);
                        }
                    }
                }
            }

            return $email;
        }

        if ($method == 'post') {
            return (new MailMessage)
                ->subject('Your Rental Statement')
                ->markdown('email-templates.statement-by-post', ['statement' => $this->statement]);
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
            //
        ];
    }
}

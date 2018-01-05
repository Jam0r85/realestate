<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StatementSentByEmailToLandlordNotification extends Notification
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
        // Build the email
        $email = new MailMessage();
        $email->subject('Your Rental Statement');
        $email->markdown('email-templates.statement-by-email', [
            'statement' => $this->statement
        ]);

        // Get and attach the statement (and invoice) to the email
        $statementFile = app('\App\Http\Controllers\DownloadController')->statement($this->statement->id);
        $email->attachData($statementFile, $this->statement->property()->present()->shortAddress . ' Statement.pdf');

        if (count($this->statement->expenses)) {
            // Loop through the expenses
            foreach ($this->statement->expenses as $expense) {
                // Check whether the expense has an invoice
                if (count($expense->publicDocuments)) {
                    // Loop through the invoices
                    foreach ($expense->publicDocuments as $invoice) {
                        // Attach the invoice and flash a message
                        $email->attach(
                            Storage::url($invoice->path), [
                                'as' => $invoice->name . '.' . $invoice->extension
                            ]);

                        flash_message('Expense Document #' . $invoice->id . ' was attached');
                    }
                }
            }
        }

        return $email;
    }
}

<?php

namespace App\Notifications;

use App\Expense;
use App\Notifications\Channels\CustomSmsChannel;
use App\Notifications\Messages\SmsMessage;
use App\StatementPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class ExpenseWasPaidToContractor extends Notification
{
    use Queueable;

    /**
     * The statement payment we are dealing with.
     * 
     * @var [type]
     */
    public $payment;

    /**
     * The expense we are dealing with.
     * 
     * @var \App\Expense
     */
    public $expense;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(StatementPayment $payment, Expense $expense)
    {
        $this->payment = $payment;
        $this->expense = $expense;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = [];

        // Make sure the user wants to receive this type of notification.
        if ($notifiable->getSetting('expense_paid_notifications') == 'email') {
            $via[] = 'mail';
        }

        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = new MailMessage();
        $mail->subject('Invoice Payment');
        $mail->markdown('email-templates.expenses.contractor-paid',
            [
                'payment' => $this->payment,
                'expense' => $this->expense
            ]
        );

        // Check whether we can attach documents to the email
        if (count($this->expense->publicDocuments)) {

            $documentFileNumber = 0;

            // Loop through all of the documents.
            foreach ($this->expense->publicDocuments as $document) {

                // Make sure the document exists in storage.
                if (Storage::exists($document->path)) {

                    $documentFileNumber++;

                    // Set the document name.
                    $documentFileName = snake_case($this->expense->name . '_' . $documentFileNumber) . '.' . $document->extension;

                    $mail->attach(
                        Storage::url($document->path), [
                            'as' => $documentFileName
                        ]
                    );

                }
            }
        }

        return $mail;
    }
}

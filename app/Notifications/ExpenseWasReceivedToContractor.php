<?php

namespace App\Notifications;

use App\Expense;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpenseWasReceivedToContractor extends Notification
{
    use Queueable;

    /**
     * The expense we are dealing with.
     * 
     * @var  \App\Expense
     */
    public $expense;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Expense $expense)
    {
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

        if ($notifiable->getSetting('expense_received_notifications') == 'email') {
            $via[] = 'mail';
        }

        // if ($notifiable->getSetting('expense_notifications') == 'sms') {
        //     $via[] = CustomSmsChannel::class;
        // }

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
        $mail->subject('Invoice Received');
        $mail->markdown('email-templates.expenses.received-to-contractor',
            [
                'expense' => $this->expense
            ]
        );

        return $mail;
    }
}

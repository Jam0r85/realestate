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

class ExpensePaymentToContractor extends Notification
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
     * @param  \App\StatementPayment $payment
     * @param  \App\Expense  $expense
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
     * @param  array  $via
     * @return array
     */
    public function via($notifiable, array $via = [])
    {
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
        return (new MailMessage)
            ->subject('Invoice Payment')
            ->markdown('email-templates.expenses.contractor-payment', [
                'payment' => $this->payment,
                'expense' => $this->expense
            ]);
    }
}

<?php

namespace App\Notifications;

use App\Expense;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class ExpenseWasReceivedToContractor extends Notification
{
    use Queueable;

    /**
     * The expense we are dealing with.
     * 
     * @var \App\Expense
     */
    public $expense;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Expense  $expense
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
     * @param  array  $via
     * @return array
     */
    public function via($notifiable, array $via = [])
    {
        // Make sure the user want's to receive this type of notification.
        if ($notifiable->getSetting('expense_received_notifications') == 'email') {
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
            ->subject('Invoice Received')
            ->markdown('email-templates.expenses.received-to-contractor', [
                'expense' => $this->expense
            ]);
    }
}

<?php

namespace App\Notifications;

use App\Invoice;
use App\User;
use App\Mail\InvoiceMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvoiceSentNotification extends Notification
{
    use Queueable;

    /**
     * The invoice we are sending.
     * 
     * @var \App\Invoice
     */
    public $invoice;

    /**
     * The user we are sending the invoice to.
     * 
     * @var \App\User
     */
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, User $user)
    {
        $this->invoice = $invoice;
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
        return (new InvoiceMailer($this->invoice))
            ->to($this->user->email);
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

<?php

namespace App\Notifications;

use App\Invoice;
use App\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaymentReceivedNotification extends Notification
{
    use Queueable;

    /**
     * The payment we are dealing with.
     */
    public $payment;

    /**
     * The payment we are dealing with.
     */
    public $invoice;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Payment  $payment
     * @param  \App\Invoice  $invoice
     * @return void
     */
    public function __construct(Payment $payment, Invoice $invoice)
    {
        $this->payment = $payment;
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
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
            ->subject('Payment Received')
            ->markdown('email-templates.invoice-payment-received', [
                'payment' => $this->payment,
                'invoice' => $this->invoice
            ]);
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
            'payment_id' => $this->payment->id,
            'invoice' => $this->invoice->present()->name,
            'amount' => $this->payment->present()->money('amount'),
            'method' => $this->payment->method->name
        ];
    }
}

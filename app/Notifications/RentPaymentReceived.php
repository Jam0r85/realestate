<?php

namespace App\Notifications;

use App\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RentPaymentReceived extends Notification
{
    use Queueable;

    public $payment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $receipt = app('\App\Http\Controllers\DownloadController')->payment($this->payment->id);

        return (new MailMessage)
            ->subject('Rent payment received')
            ->markdown('notifications.rent-payment-received', ['payment' => $this->payment])
            ->attachData($receipt, 'Receipt ' . $this->payment->id .'.pdf');
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
            'amount' => $this->payment->amount,
            'method' => $this->payment->method->name,
            'note' => $this->payment->note
        ];
    }
}

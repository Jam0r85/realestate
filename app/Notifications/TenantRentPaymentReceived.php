<?php

namespace App\Notifications;

use App\Payment;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TenantRentPaymentReceived extends Notification
{
    /**
     * The payment we are sending.
     * 
     * @var \App\Payment
     */
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
        if (user_setting('rent_payment_received_notification_email', $notifiable)) {
            $via[] = 'mail';
        }

        if (user_setting('rent_payment_received_notification_sms', $notifiable)) {
            $via[] = 'nexmo';
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
        $receipt = app('\App\Http\Controllers\DownloadController')->payment($this->payment->id);

        return (new MailMessage)
            ->subject('Rent Payment Received')
            ->markdown('email-templates.tenant-rent-payment-received', ['payment' => $this->payment])
            ->attachData($receipt, 'Receipt ' . $this->payment->id .'.pdf');
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content('Your SMS message content')
            ->unicode();
    }
}

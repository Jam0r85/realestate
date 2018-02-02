<?php

namespace App\Notifications;

use App\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TenancyRentPaymentReceived extends Notification
{
    use Queueable;

    /**
     * The payment we are sending.
     */
    public $payment;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Payment  $payment
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
     * @param  array  $via
     * @return array
     */
    public function via($notifiable)
    {
        $via[] = 'database';
        
        if ($notifiable->getSetting('rent_payment_notifications') == 'email') {
            $via[] = 'mail';
        }

        if ($notifiable->getSetting('rent_payment_notifications') == 'sms') {
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
        return (new MailMessage)
            ->subject('Payment Received')
            ->markdown('email-templates.tenant-rent-payment-received', [
                'payment' => $this->payment
            ]);
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        $content = 'We have received your rent payment of ' . $this->payment->present()->money('amount') . '. Thank you, ' . config('app.name');

        return (new NexmoMessage)
            ->content($content)
            ->unicode();
    }

    /**
     * Get the array representation of the notification.
     * 
     * @param   mixed  $notifiable
     * @return  array
     */
    public function toArray($notifiable)
    {
        return [
            'payment_id' => $this->payment->id,
            'amount' => $this->payment->present()->money('amount'),
            'method' => $this->payment->method->name
        ];
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContractorPaymentSent extends Mailable
{
    use Queueable, SerializesModels;

    public $payments;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payments)
    {
        $this->payments = $payments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email-templates.contractor-payment-sent');
    }
}

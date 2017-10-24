<?php

namespace App\Mail;

use App\Gas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GasInspectionReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $gas;
    public $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Gas $gas, $body)
    {
        $this->gas = $gas;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->gas->property->short_name . ' - Gas Inspection')
            ->markdown('email-templates.gas-inspection-reminder');
    }
}

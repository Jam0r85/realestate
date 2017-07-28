<?php

namespace App\Mail;

use App\Statement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatementToLandlord extends Mailable
{
    use Queueable, SerializesModels;

    public $statement;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email-templates.statement-to-landlord');
    }
}

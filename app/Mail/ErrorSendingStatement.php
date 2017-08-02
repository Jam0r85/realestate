<?php

namespace App\Mail;

use App\Statement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ErrorSendingStatement extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Statement
     */
    public $statement;

    /**
     * @var string
     */
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Statement $statement, $error)
    {
        $this->statement = $statement;
        $this->message = $this->messageStore($error);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Error Sending Statement Notification')
            ->markdown('email-templates.error-sending-statement');
    }

    /**
     * Storage for all statement errors.
     * 
     * @param  string $error
     * @return string
     */
    public function messageStore($error)
    {
        if ($error == 'missing-email') {
            return 'Missing email';
        }

        return 'There was an error sending this statement however the error was not provided';
    }
}

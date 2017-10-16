<?php

namespace App\Mail;

use App\Statement;

class StatementByPost extends BaseMailer
{
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
        return $this->subject('Rental Statement: ' . $this->statement->property->short_name)
            ->markdown('email-templates.statement-by-post');
    }
}

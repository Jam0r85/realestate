<?php

namespace App\Mail;

use App\Statement;

class StatementByPost extends BaseMailer
{
    /**
     * The statement we are sending.
     * 
     * @var \App\Statement
     */
    public $statement;

    /**
     * Create a new message instance.
     *
     * @param \App\Statement $statement
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

<?php

namespace App\Mail;

use App\Http\Controllers\DownloadController;
use App\Statement;
use Illuminate\Support\Facades\Storage;

class StatementByEmail extends BaseMailer
{
    /**
     * The statement we are sending.
     * 
     * @var \App\Statement
     */
    public $statement;

    /**
     * The default email blade template to used when sending the email.
     * 
     * @var string
     */
    public $template = 'email-templates.statement-by-email';

    /**
     * The email blade template to be used if the statement has not been sent before.
     * 
     * @var string
     */
    public $first_template = 'email-templates.statement-by-email-first';

    /**
     * Create a new message instance.
     *
     * @param \App\Statement $statement
     */
    public function __construct(Statement $statement)
    {
        $this->statement = $statement;

        // Overwrite the template if the statement has not been sent before.
        if (is_null($this->statement->sent_at)) {
            $this->template = $this->first_template;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Grab the statement..
        // MUST BE A NICER WAY TO DO THIS!
        $statement = app('\App\Http\Controllers\DownloadController')->statement($this->statement->id, 'raw');

        $this->subject('Rental Statement: ' . $this->statement->property->short_name);
        $this->attachData($statement, $this->statement->property->short_name . ' Statement.pdf');
        $this->markdown($this->template);
        
        if (count($this->statement->expenses)) {
            // Loop through the expenses
            foreach ($this->statement->expenses as $expense) {
                // Check whether the expense has an invoice
                if (count($expense->documents)) {
                    foreach ($expense->documents as $invoice) {
                        $this->attach(
                            Storage::url($invoice->path), [
                                'as' => $invoice->name . '.' . $invoice->extension
                            ]);
                    }
                }
            }
        }

        return $this;
    }
}

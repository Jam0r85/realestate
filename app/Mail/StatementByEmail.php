<?php

namespace App\Mail;

use App\Http\Controllers\DownloadController;
use App\Statement;
use Illuminate\Support\Facades\Storage;

class StatementByEmail extends BaseMailer
{
    public $statement;

    /**
     * Create a new message instance.
     *
     * @param \App\Statement $statement
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
        // Grab the statement..
        // MUST BE A NICER WAY TO DO THIS!
        $statement = app('\App\Http\Controllers\DownloadController')->statement($this->statement->id);

        $this->subject('Rental Statement: ' . $this->statement->property->short_name);
        $this->attachData($statement, $this->statement->property->short_name . ' Statement.pdf');
        $this->markdown('email-templates.statement-by-email');
        
        if (count($this->statement->expenses)) {
            // Loop through the expenses
            foreach ($this->statement->expenses as $expense) {
                // Check whether the expense has an invoice
                if (count($expense->invoices)) {
                    foreach ($expense->invoices as $invoice) {
                        $this->attach(
                            Storage::url($invoice->path), [
                                'as' => $expense->name . '.' . $invoice->extension
                            ]);
                    }
                }
            }
        }

        return $this;
    }
}

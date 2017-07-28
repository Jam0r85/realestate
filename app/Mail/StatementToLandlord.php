<?php

namespace App\Mail;

use App\Http\Controllers\DownloadController;
use App\Statement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

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
        // Check which markdown we want to use.
        if ($this->statement->sendByPost()) {
            $this->subject('Your rental statement is on the way');
            $this->markdown('email-templates.statement-to-landlord-post', ['statement' => $this->statement]);
        } else {
            $this->subject('Your rental statement is attached');
            $this->attachData(DownloadController::statement($this->statement->id), $this->statement->tenancy->property->short_name . ' Statement.pdf');
            $this->markdown('email-templates.statement-to-landlord-email', ['statement' => $this->statement]);
            
            // Check whether the statement has any expense payments
            if (count($this->statement->expenses)) {
                // Loop through the expenses
                foreach ($this->statement->expenses as $expense) {
                    // Check whether the expense has an invoice
                    if ($expense->invoice) {
                        // Attach the invoice to the email
                        $this->attachData(Storage::get($expense->invoice->path), $expense->name . '.' . $expense->invoice->extension);
                    }
                }
            }
        }

        return $this;
    }
}

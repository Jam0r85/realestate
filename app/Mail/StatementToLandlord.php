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
        // Build the email.
        $email = new MailMessage();

        // Check which markdown we want to use.
        if ($this->statement->sendByPost()) {
            $email->subject('Your rental statement is on the way');
            $email->markdown('email-templates.statement-to-landlord-post', ['statement' => $this->statement]);
        } else {
            $email->subject('Your rental statement is attached');
            $email->attachData(DownloadController::statement($this->statement->id), $this->statement->tenancy->property->short_name . ' Statement.pdf');
            $email->markdown('email-templates.statement-to-landlord-email', ['statement' => $this->statement]);
            
            // Check whether the statement has any expense payments
            if (count($this->statement->expenses)) {
                // Loop through the expenses
                foreach ($this->statement->expenses as $expense) {
                    // Check whether the expense has an invoice
                    if ($expense->invoice) {
                        // Attach the invoice to the email
                        $email->attachData(Storage::get($expense->invoice->path), $expense->name . '.' . $expense->invoice->extension);
                    }
                }
            }
        }

        return $email;
    }
}

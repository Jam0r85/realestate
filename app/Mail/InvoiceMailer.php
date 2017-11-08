<?php

namespace App\Mail;

use App\Http\Controllers\DownloadController;
use App\Invoice;
use Illuminate\Support\Facades\Storage;

class InvoiceMailer extends BaseMailer
{
    /**
     * The invoice we are sending.
     * 
     * @var \App\Invoice
     */
    public $invoice;

    /**
     * The default email blade template to used when sending the invoice.
     * 
     * @var string
     */
    public $template = 'email-templates.invoice-to-user';

    /**
     * Create a new message instance.
     *
     * @param \App\Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Grab the invoice..
        // MUST BE A NICER WAY TO DO THIS!
        $invoice = app('\App\Http\Controllers\DownloadController')->invoice($this->invoice->id);

        $this->subject('Your Invoice');
        $this->attachData($invoice, $this->invoice->name . '.pdf');
        $this->markdown($this->template);

        return $this;
    }
}

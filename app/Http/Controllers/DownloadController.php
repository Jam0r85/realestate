<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Repositories\EloquentInvoicesRepository;
use App\Repositories\EloquentPaymentsRepository;
use App\Repositories\EloquentStatementsRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DownloadController extends Controller
{
    /**
     * @var  App\Repositories\EloquentStatementsRepository
     */
    protected $statements;

    /**
     * @var  App\Repositories\EloquentInvoicesRepository
     */
    protected $invoices;

    /**
     * @var  App\Repositories\EloquentPaymentsRepository
     */
    protected $payments;

    /**
     * @var  Dompdf\Dompdf
     */
    protected $pdf;

    /**
     * @var Dompdf\Options
     */
    protected $options;

    /**
     * Create a new controller instance.
     *
     * @param   Dompdf\Options                $options
     * @param   EloquentStatementsRepository  $statements
     * @param   EloquentInvoicesRepository    $invoices
     * @param   EloquentPaymentsRepository    $payments
     * @return  void
     */
    public function __construct(Options $options, EloquentStatementsRepository $statements, EloquentInvoicesRepository $invoices, EloquentPaymentsRepository $payments)
    {
        $this->middleware('auth');

        $this->options = $options;
        $this->statements = $statements;
        $this->invoices = $invoices;
        $this->payments = $payments;

        $this->options->set('isRemoteEnabled', true);
        $this->options->set('isHtml5ParserEnabled', true);

        $this->pdf = new Dompdf($this->options);

        $contxt = stream_context_create([ 
            'ssl' => [ 
                'verify_peer' => FALSE, 
                'verify_peer_name' => FALSE,
                'allow_self_signed'=> TRUE
            ] 
        ]);

        $this->pdf->setHttpContext($contxt);
    }

    /**
     * Get the view along with the data.
     * 
     * @param  $view
     * @param  array  $data
     * @return string
     */
    public function getView($view, $data = [])
    {
        return view($view, $data)->render();
    }

    /**
     * Render the PDF.
     * 
     * @return Dompdf\Dompdf
     */
    public function render()
    {
        $this->pdf->render();
    }

    /**
     * Stream the PDF.
     * 
     * @param  string $filename
     * @return \Illuminate\Http\Response
     */
    public function stream($filename = 'document.pdf')
    {
        $this->render();
        
        return new Response($this->pdf->output(), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'inline; filename="' . $filename . '"',
        ));
    }

    /**
     * Return the PDF as a raw file.
     * 
     * @return mixed
     */
    public function raw()
    {
        //
    }

    /**
     * Download a rental statement.
     * 
     * @param  \App\Statement $id
     * @return \Illuminate\Http\Response
     */
    public function statement($id, $return = 'stream')
    {
        $statement = $this->statements->find($id);
		$pdf_name = 'Statement ' . $statement->id;
        $this->pdf->loadHtml($this->getView('pdf.statement', ['statement' => $statement, 'title' => $statement->property->short_name]));
        return $this->$return();
    }

    /**
     * Download an invoice.
     * 
     * @param  \App\Invoice $id
     * @return \Illuminate\Http\Response
     */
    public function invoice($id, $return = 'stream')
    {
        $invoice = Invoice::withTrashed()->findOrFail($id);
        $pdf_name = 'Invoice ' . $invoice->name;
        $this->pdf->loadHtml(
            $this->getView('pdf.invoice', [
                'invoice' => $invoice,
                'title' => 'Invoice ' . $invoice->number
            ]
        ));

        return $this->$return();
    }

    /**
     * Download a payment receipt.
     * 
     * @param  \App\Payment $id
     * @return \Illuminate\Http\Response
     */
    public function payment($id, $return = 'stream')
    {
        $payment = $this->payments->find($id);
        $pdf_name = 'Payment ' . $payment->id;
        $this->pdf->loadHtml($this->getView('pdf.payment', ['payment' => $payment, 'title' => 'Payment ' . $payment->id]));
        return $this->$return();
    }
}

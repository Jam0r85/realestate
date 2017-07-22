<?php

namespace App\Http\Controllers;

use App\Repositories\EloquentInvoicesRepository;
use App\Repositories\EloquentPaymentsRepository;
use App\Repositories\EloquentStatementsRepository;
use Dompdf\Dompdf;
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
     * Create a new controller instance.
     * 
     * @param   EloquentStatementsRepository  $statements
     * @param   EloquentInvoicesRepository    $invoices
     * @param   EloquentPaymentsRepository    $payments
     * @param   Dompdf\Dompdf                 $pdf
     * @return  void
     */
    public function __construct(Dompdf $pdf, EloquentStatementsRepository $statements, EloquentInvoicesRepository $invoices, EloquentPaymentsRepository $payments)
    {
        $this->middleware('auth');

        $this->statements = $statements;
        $this->invoices = $invoices;
        $this->payments = $payments;
        $this->pdf = $pdf;
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
     * Stream the PDF.
     * 
     * @param  string $filename
     * @return \Illuminate\Http\Response
     */
    public function stream($filename = 'document.pdf')
    {
        $this->pdf->render();
        
        return new Response($this->pdf->output(), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'inline; filename="' . $filename . '"',
        ));
    }

    /**
     * Download a rental statement.
     * 
     * @param  \App\Statement $id
     * @return \Illuminate\Http\Response
     */
    public function statement($id)
    {
        $statement = $this->statements->find($id);
		$pdf_name = 'Statement ' . $statement->id;
        $this->pdf->loadHtml($this->getView('pdf.statement', ['statement' => $statement]));
        return $this->stream();
    }

    /**
     * Download an invoice.
     * 
     * @param  \App\Invoice $id
     * @return \Illuminate\Http\Response
     */
    public function invoice($id)
    {
        $invoice = $this->invoices->find($id);
        $pdf_name = 'Invoice ' . $invoice->number;
        $this->pdf->loadHtml($this->getView('pdf.invoice', ['invoice' => $invoice]));
        return $this->stream();
    }

    /**
     * Download a payment receipt.
     * 
     * @param  \App\Payment $id
     * @return \Illuminate\Http\Response
     */
    public function payment($id)
    {
        $payment = $this->payments->find($id);
        $pdf_name = 'Payment ' . $payment->id;
        $this->pdf->loadHtml($this->getView('pdf.payment', ['payment' => $payment]));
        return $this->stream();
    }
}

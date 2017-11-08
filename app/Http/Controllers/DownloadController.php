<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Statement;
use App\Payment;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
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
     * @param Dompdf\Options $options
     * @return  void
     */
    public function __construct(Options $options)
    {
        $this->middleware('auth');

        $this->options = $options;

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
     * @param integer $id
     * @param string $return
     * @return
     */
    public function statement($id, $return = 'stream')
    {
        $statement = Statement::withTrashed()->findOrFail($id);

        $this->pdf->loadHtml(
            $this->getView('pdf.statement', [
                'statement' => $statement,
                'title' => $statement->property->short_name
            ]
        ));

        return $this->$return();
    }

    /**
     * Download an invoice.
     * 
     * @param integer $id
     * @param string $return
     * @return
     */
    public function invoice($id, $return = 'stream')
    {
        $invoice = Invoice::withTrashed()->findOrFail($id);

        $this->pdf->loadHtml(
            $this->getView('pdf.invoice', [
                'invoice' => $invoice,
                'title' => 'Invoice ' . $invoice->name
            ]
        ));

        return $this->$return();
    }

    /**
     * Download a payment receipt.
     * 
     * @param integer $id
     * @param string $return
     * @return
     */
    public function payment($id, $return = 'stream')
    {
        $payment = Payment::findOrFail($id);

        $this->pdf->loadHtml(
            $this->getView('pdf.payment', [
                'payment' => $payment,
                'title' => 'Payment ' . $payment->id
            ]
        ));

        return $this->$return();
    }
}

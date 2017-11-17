<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Payment;
use App\Statement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DownloadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return  void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Download a rental statement.
     * 
     * @param integer $id
     * @return
     */
    public function statement($id)
    {
        $statement = Statement::withTrashed()->findOrFail($id);
        return $statement->streamPdf();
    }

    /**
     * Download an invoice.
     * 
     * @param integer $id
     * @return
     */
    public function invoice($id)
    {
        $invoice = Invoice::withTrashed()->findOrFail($id);
        return $invoice->streamPdf();
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
        return $payment->streamPdf();
    }
}

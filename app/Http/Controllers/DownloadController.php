<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Payment;
use App\Statement;
use Barryvdh\DomPDF\Facade as PDF;
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
        PDF::setOptions(['isHtml5ParserEnabled' => true]);
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
        return PDF::loadView('pdf.statement', [
            'statement' => Statement::withTrashed()->findOrFail($id),
            'title' => 'Statement ' . $id
        ])->$return();
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
        return PDF::loadView('pdf.invoice', [
            'invoice' => Invoice::withTrashed()->findOrFail($id),
            'title' => 'Invoice ' . $id
        ])->$return();
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
        return PDF::loadView('pdf.payment', [
            'payment' => Payment::findOrFail($id),
            'title' => 'Payment ' . $id
        ])->$return();
    }
}

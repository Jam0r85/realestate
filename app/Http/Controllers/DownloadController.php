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
     * Check whether the file exists either locally or in the backup.
     * 
     * @param string $file
     * @return void
     */
    public function checkFileExists($file, $exists = false)
    {
        if (Storage::exists($file)) {
            $exists = true;
        }

        return $exists;
    }

    /**
     * @param  [type]
     * @param  [type]
     * @return [type]
     */
    public function store($file, $pdf)
    {
        if (!$this->checkFileExists($file)) {
            return Storage::put($file, $pdf->output());
        }
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
        return $statement->createPdf();
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
        return $invoice->createPdf();
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
        return $payment->createPdf();
    }
}

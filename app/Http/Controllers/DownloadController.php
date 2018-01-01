<?php

namespace App\Http\Controllers;

use App\Document;
use App\Invoice;
use App\Payment;
use App\Statement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
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

    /**
     * Download a document.
     * 
     * @param  int  $id
     * @return
     */
    public function document($id)
    {
        $document = Document::withTrashed()->findOrFail($id);

        if (Storage::exists($document->path)) {
            return Storage::response($document->path);
        }
    }
}

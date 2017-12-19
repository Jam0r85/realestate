<?php

namespace App\Http\Controllers;

use App\Document;
use App\Http\Requests\DepositStorePaymentRequest;
use App\Http\Requests\DepositUpdateRequest;
use App\Http\Requests\StoreDepositRequest;
use App\Payment;
use App\Services\PaymentService;
use App\Tenancy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DepositController extends BaseController
{

    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Deposit';

    /**
     * Display a listing of deposits.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $deposits = $this->repository
            ->with('payments','owner','tenancy','certificate','tenancy.property')
            ->filter($request->all())
            ->latest()
            ->paginate();

        return view('deposits.index', compact('deposits'));
    }

    /**
     * Store a newly create deposit in storage.
     *
     * @param  \App\Http\Requests\StoreDepositRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepositRequest $request)
    {
        $deposit = new Deposit();
        $deposit->user_id = Auth::user()->id;
        $deposit->tenancy_id = $request->tenancy_id;
        $deposit->amount = $request->amount;
        $deposit->unique_id = $request->unique_id;
        $deposit->save();

        return back();
    }

    /**
     * Update the deposit in storage.
     *
     * @param \App\Http\Requests\DepositUpdateRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepositUpdateRequest $request, $id)
    {
        $deposit = Deposit::findOrFail($id);

        $deposit->unique_id = $request->unique_id;
        $deposit->amount = $request->amount;
        $deposit->save();

        return back();
    }

    /**
     * Upload the certificate for a deposit.
     * 
     * @param \App\Http\Requests\ $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function uploadCertificate(Request $request, $id)
    {
        $deposit = Deposit::findOrFail($id);

        if ($deposit->certificate) {
            $this->destroyCertificate($id);
        }

        if ($request->hasFile('certificate')) {

            $folder = 'documents/tenancies/' . $deposit->tenancy_id . '/deposit';
            $path = $request->file('certificate')->store($folder);

            $file = new Document();
            $file->user_id = Auth::user()->id;
            $file->key = str_random(30);
            $file->name = $deposit->unique_id ?? 'Deposit Certificate #' . $deposit->id;
            $file->path = $path;
            $file->extension = $request->file('certificate')->getClientOriginalExtension();

            $deposit->certificate()->save($file);
        }

        return back();
    }

    /**
     * Destroy the deposit certificate.
     * 
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroyCertificate($id)
    {
        $deposit = Deposit::findOrFail($id);

        Storage::delete($deposit->certificate->path);
        $deposit->certificate()->delete();

        return back();
    }
}

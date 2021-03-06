<?php

namespace App\Http\Controllers;

use App\Events\RentPaymentWasCreated;
use App\Http\Requests\RentPaymentStoreRequest;
use App\Http\Requests\SearchRequest;
use App\Notifications\TenantRentPaymentReceived;
use App\Tenancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class RentPaymentController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Payment';

	/**
	 * Store a rent payment into storage.
	 * 
	 * @param  \App\Http\Requests\RentPaymentStoreRequest  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
    public function store(RentPaymentStoreRequest $request, $id)
    {
        // Find the tenancy
        $tenancy = Tenancy::withTrashed()->findOrFail($id);

        // Store the payment to the tenancy
    	$payment = $tenancy->storeRentPayment(
            $this->repository->fill($request->all())
        );

        event(new RentPaymentWasCreated($payment->fresh()));

    	return back();
    }

    /**
     * Show a printable version of payments received.
     * 
     * @param  Tenancy  $tenancy
     * @return  Illuminate\Http\Response
     */
    public function print(Tenancy $tenancy)
    {
        return view('rent-payments.print', compact('tenancy'));
    }

    /**
     * Show a printable version of payments received with statements.
     * 
     * @param  Tenancy  $tenancy
     * @return  Illuminate\Http\Response
     */
    public function printWithStatements(Tenancy $tenancy)
    {
        $payments = $tenancy->rent_payments;
        $statements = $tenancy->statements;

        $merged = $payments->merge($statements);
        $merged = $merged->sortBy('created_at');

        $balance = 0;

        foreach ($merged as $item) {

            $item->name = class_basename($item);

            if (class_basename($item) == 'Payment') {
                $item->other = $item->method->name;
                $balance = $balance + $item->amount;
            } elseif (class_basename($item) == 'Statement') {
                $item->other = $item->present()->period;
                $balance = $balance - $item->amount;
            }

            $item->balance = $balance;
        }

        return view('rent-payments.print-with-statements', compact('tenancy','merged'));
    }
}

<?php

namespace App\Services;

use App\Deposit;
use App\Invoice;
use App\Payment;
use App\Tenancy;
use Carbon\Carbon;

class PaymentService
{
	/**
	 * Create an invoice payment.
	 * 
	 * @param array $data
	 * @param integer $id
	 * @return \App\Payment
	 */
	public function createInvoicePayment(array $data, $id)
	{
		$invoice = Invoice::findOrFail($id);

		$payment = new Payment();
		$payment->key = str_random(30);
		$payment->amount = $data['amount'];
		$payment->payment_method_id = $data['payment_method_id'];

		$payment = $invoice->payments()->save($payment);

		$payment->users()->attach($invoice->users);

		$invoice->fresh();
		
		if (is_null($invoice->paid_at) && $invoice->total_balance <= 0) {
			$invoice->paid_at = Carbon::now();
			$invoice->save();
		}

		return $payment;
	}

	/**
	 * Create a rent payment for a tenancy.
	 * 
	 * @param array $data
	 * @param integer $id
	 * @return \App\Payment
	 */
	public function createTenancyRentPayment(array $data, $id)
	{
		// Find the tenancy.
		$tenancy = Tenancy::findOrFail($id);

		// Build the payment.
		$payment = new Payment();
		$payment->key = str_random(30);
		$payment->fill($data);

		if (isset($data['created_at'])) {
			$payment->created_at = $payment->updated_at = Carbon::createFromFormat('Y-m-d', $data['created_at']);
		}

		// Create and store the payment.
		$payment = $tenancy->rent_payments()->save($payment);

		// Attach the tenants as the payment users.
		$payment->users()->attach($tenancy->tenants);

		return $payment;
	}

	/**
	 * Record a payment for a deposit.
	 * 
	 * @param array $data
	 * @param integer $id
	 * @return \App\Payment
	 */
	public function createDepositPayment(array $data, $id)
	{
		$deposit = Deposit::findOrFail($id);

		// Build the payment.
		$payment = new Payment();
		$payment->key = str_random(30);
		$payment->fill($data);

		if (isset($data['created_at'])) {
			$payment->created_at = $payment->updated_at = Carbon::createFromFormat('Y-m-d', $data['created_at']);
		}

		$payment = $deposit->payments()->save($payment);

		return $payment;
	}
}
<?php

namespace App\Services;

use App\Invoice;
use App\Payment;

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

		return $payment;
	}
}
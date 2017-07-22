<?php

namespace App\Repositories;

use App\Payment;

class EloquentPaymentsRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Payment';
	}

	/**
	 * Get all of the rent payments.
	 * 
	 * @return mixed
	 */
	public function getRentPaymentsPaged()
	{
		return $this->getInstance()->RentPayments()->latest()->paginate();
	}

	/**
	 * Create a new payment.
	 * 
	 * @param  array  $data
	 * @param  parent $parent
	 * @param  string $payment_method
	 * @return mixed
	 */
	public function createPayment(array $data, $parent, $payment_method = 'payments')
	{
		if (!method_exists($parent, $payment_method)) {
			return;
		}

		// Create a random key.
		$data['key'] = str_random(30);

		// Create the payment
		$payment = $parent->$payment_method()->create($data);

		// Attach users
		if (isset($data['user_id'])) {
			$payment->users()->attach($data['user_id']);
		}

		// Flash a success message.
		$this->successMessage('The payment was created');

		// Return the Payment.
		return $payment;
	}
}
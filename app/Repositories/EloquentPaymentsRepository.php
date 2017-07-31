<?php

namespace App\Repositories;

use App\Payment;
use Carbon\Carbon;

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
	public function createPayment(array $data, $parent, $payment_method = 'payments', $users_relation = 'users')
	{
		if (!method_exists($parent, $payment_method)) {
			return;
		}

		// Create a random key.
		$data['key'] = str_random(30);

		// Check whether the created_at date has been provided.
		if (isset($data['created_at'])) {
			$data['created_at'] = Carbon::createFromFormat('Y-m-d', $data['created_at']);
		} else {
			$data['created_at'] = Carbon::now();
		}

		// Create the payment
		$payment = $parent->$payment_method()->create($data);

		// Attach users
		if (isset($data['user_id'])) {
			$payment->users()->attach($data['user_id']);
		} else {
			if (method_exists($parent, $users_relation)) {
				$payment->users()->attach($parent->$users_relation);
			}
		}

		// Flash a success message.
		$this->successMessage('The payment was created');

		// Return the Payment.
		return $payment;
	}
}
<?php

namespace App\Repositories;

use App\Repositories\EloquentPaymentsRepository;
use App\Tenancy;

class EloquentTenanciesRepository extends EloquentBaseRepository
{
	/**
	 * @var  App\Repositories\EloquentPaymentsRepository
	 */
	public $payments;

    /**
     * Create a new repository instance.
     * 
     * @param   EloquentPaymentsRepository $payments
     * @return  void
     */
	public function __construct(EloquentPaymentsRepository $payments)
	{
		$this->payments = $payments;
	}

	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Tenancy';
	}

	/**
	 * Get all of the tenancies order by their balance.
	 * 
	 * @return \App\Tenancy
	 */
	public function getWithRentBalance()
	{
		return $this->getInstance()->withRentBalance();
	}

	/**
	 * Store a new rent payment for a tenancy.
	 * 
	 * @param  array        $data
	 * @param  \App\Tenancy $id
	 * @return \App\Tenancy
	 */
	public function createRentPayment(array $data, $id)
	{
		// Find the tenancy.
		$tenancy = $this->find($id);

		// Create this payment.
		$payment = $this->payments->createPayment($data, $tenancy, 'rent_payments');

		// Flash a success message.
		$this->successMessage('The payment was recorded');

		return $tenancy;
	}
}
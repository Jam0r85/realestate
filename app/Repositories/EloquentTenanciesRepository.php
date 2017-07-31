<?php

namespace App\Repositories;

use App\Repositories\EloquentInvoicesRepository;
use App\Repositories\EloquentPaymentsRepository;
use App\Repositories\EloquentStatementsRepository;
use App\Tenancy;
use Carbon\Carbon;

class EloquentTenanciesRepository extends EloquentBaseRepository
{
	/**
	 * @var  App\Repositories\EloquentPaymentsRepository
	 * @var  App\Repositories\EloquentStatementsRepository
	 * @var  App\Repositories\EloquentInvoicesRepository
	 */
	public $payments;
	public $statements;
	public $invoices;

    /**
     * Create a new repository instance.
     * 
     * @param   EloquentPaymentsRepository   $payments
     * @param   EloquentStatementsRepository $statements
     * @param   EloquentInvoicesRepository   $invoices
     * @return  void
     */
	public function __construct(EloquentPaymentsRepository $payments, EloquentStatementsRepository $statements, EloquentInvoicesRepository $invoices)
	{
		$this->payments = $payments;
		$this->statements = $statements;
		$this->invoices = $invoices;
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
	 * Get all of the tenancies that are overdue with their rental statements.
	 * 
	 * @return \App\Tenancy
	 */
	public function getOverdueList()
	{
		return $this->getInstance()->whereIsOverdue(1)->get()->sortByDesc('days_overdue');
	}

	/**
	 * Get all of the tenancies order by their balance.
	 * 
	 * @return \App\Tenancy
	 */
	public function getWithRentBalance()
	{
		return $this->getInstance()->withRentBalance()->get()->where('rent_balance', '>', 0);
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

		// Create a statement if the balance held is enough
		if ($tenancy->canCreateStatement()) {
			$this->statements->createStatement(array_only($data, ['amount']), $tenancy->id);
		}

		return $tenancy;
	}

	/**
	 * Update the discounts in storage for a tenancy.
	 * 
	 * @param  array  $discounts [description]
	 * @param  [type] $id        [description]
	 * @return [type]            [description]
	 */
	public function updateDiscounts($discounts = [], $id)
	{
		$tenancy = $this->find($id);

		if (!count($discounts)) {
			$tenancy->discounts()->detach();
		} else {
			$tenancy->discounts()->attach($discounts, ['for' => 'service']);
		}

		$this->successMessage('The discounts were updated');

		return $tenancy;
	}
}
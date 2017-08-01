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
		$payment = $this->payments->createPayment($data, $tenancy, 'rent_payments', 'tenants');

		// Flash a success message.
		$this->successMessage('The payment was recorded');

		// Create a statement if the balance held is enough
		if (isset($data['create_auto_statement'])) {
			if ($tenancy->canCreateStatement()) {
				$statement = $this->statements->createStatement(array_only($data, ['amount']), $tenancy->id);
				return redirect()->route('statements.show', $statement->id);
			}
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

	/**
	 * Record the tenants having vacated a tenancy.
	 * 
	 * @param  date 		$vacated_on
	 * @param  integer 		$id
	 * @return mixed
	 */
	public function tenantsVacated($vacated_on, $id)
	{
		if ($vacated_on) {
			$data['vacated_on'] = Carbon::createFromFormat('Y-m-d', $vacated_on);
		} else {
			$data['vacated_on'] = NULL;
		}

		$tenancy = $this->update($data, $id);
		$this->successMessage('The tenants were recorded as vacating');
		return $tenancy;
	}

	/**
	 * Archive a tenancy.
	 * 
	 * @param  integer $id
	 * @return \App\Tenancy
	 */
	public function archiveTenancy($id)
	{
		$data = [
			'is_overdue' => false
		];
		
		$tenancy = $this->archive($id, $data);
		return $tenancy;
	}
}
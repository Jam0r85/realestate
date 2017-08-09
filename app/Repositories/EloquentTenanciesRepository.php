<?php

namespace App\Repositories;

use App\Agreement;
use App\Tenancy;
use App\TenancyRent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EloquentTenanciesRepository extends EloquentBaseRepository
{
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
		return $this->getInstance()
			->whereIsOverdue(1)
			->get()
			->sortByDesc('days_overdue');
	}

	/**
	 * Create a new tenancy.
	 * 
	 * @param array $data
	 * @return \App\Tenancy
	 */
	public function createTenancy(array $data)
	{
		// Store the tenancy.
		$tenancy = $this->create(array_only($data, ['service_id','property_id']));

		// Attach the tenants
		$tenancy->tenants()->attach($data['users']);

		// Store the tenancy agreement.
		$agreement = Agreement::createAgreement([
			'user_id' => Auth::user()->id,
			'tenancy_id' => $tenancy->id,
			'starts_at' => Carbon::createFromFormat('Y-m-d', $data['start_date']),
			'length' => str_slug($data['length'])
		]);

		// Store the tenancy rent amount.
		$rent = TenancyRent::create([
			'user_id' => Auth::user()->id,
			'tenancy_id' => $tenancy->id,
			'amount' => $data['rent_amount'],
			'starts_at' => $agreement->starts_at
		]);

		return $tenancy;
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
				
				$data = [
					'is_auto' => true
				];

				$this->statements->createStatement($data, $tenancy->id);
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
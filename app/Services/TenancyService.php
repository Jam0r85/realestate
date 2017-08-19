<?php

namespace App\Services;

use App\Agreement;
use App\Payment;
use App\Tenancy;
use App\TenancyRent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TenancyService
{
	/**
	 * Create a new tenancy.
	 * 
	 * @param array $data
	 * @return \App\Tenancy
	 */
	public function createTenancy(array $data)
	{
		// Store the tenancy.
		$tenancy = new Tenancy();
		$tenancy->user_id = Auth::user()->id;
		$tenancy->branch_id = 1;
		$tenancy->service_id = $data['service_id'];
		$tenancy->property_id = $data['property_id'];
		$tenancy->save();

		// Attach the tenants
		$tenancy->tenants()->attach($data['users']);

		// Save the tenancy agreement.
		$this->createTenancyAgreement([
			'starts_at' => $data['start_date'],
			'length' => $data['length']
		], $tenancy);

		// Save the rent amount.
		$this->createRentAmount([
			'amount' => $data['amount'],
			'starts_at' => $data['start_date']
		], $tenancy);

		// Save the rent amount
		$tenancy->rents()->save($rent);

		return $tenancy;
	}

	/**
	 * Calculate the end date when given the start date and the length.
	 * 
	 * @param \Carbon\Carbon $start
	 * @param string $length
	 * @return mixed
	 */
	public function calculateEndDate($start, $length)
	{
        list($number, $modifier) = explode('-', $length);

        if ($number == 0) {
            return null;
        }

        if ($number > 0) {
            $ends_at = clone $start;
            return $ends_at->addMonth($number)->subDay();
        }
	}

	/**
	 * Create a rent amount for the given tenancy.
	 * 
	 * @param array $data
	 * @param \App\Tenancy $tenancy
	 * @return \App\TenancyRent
	 */
	public function createRentAmount(array $data, Tenancy $tenancy)
	{
		// Format the starts_at date.
		if (isset($data['starts_at'])) {
			$data['starts_at'] = Carbon::createFromFormat('Y-m-d', $data['starts_at']);
		}

		$rent = new TenancyRent();
		$rent->user_id = Auth::user()->id;
		$rent->fill($data);

		// Save the rent amount
		$tenancy->rents()->save($rent);

		return $rent;
	}

	/**
	 * Create a tenancy agreement for the given tenancy.
	 * 
	 * @param array $data
	 * @param \App\Tenancy $tenancy
	 * @return \App\Agreement
	 */
	public function createTenancyAgreement(array $data, Tenancy $tenancy)
	{
		if (isset($data['starts_at'])) {
			$data['starts_at'] = Carbon::createFromFormat('Y-m-d', $data['starts_at']);
		}

		if (isset($data['length'])) {
			$data['length'] = str_slug($data['length']);
		}

		$agreement = new Agreement();
		$agreement->user_id = Auth::user()->id;
		$agreement->fill($data);
		$agreement->ends_at = $this->calculateEndDate($agreement->starts_at, $agreement->length);

		$tenancy->agreements()->save($agreement);

		return $agreement;
	}
}
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

		// Build the tenancy agreement.
		$agreement = new Agreement();
		$agreement->user_id = Auth::user()->id;
		$agreement->starts_at = Carbon::createFromFormat('Y-m-d', $data['start_date']);
		$agreement->length = str_slug($data['length']);
		$agreement->ends_at = $this->calculateEndDate($agreement->starts_at, $agreement->length);

		// Save the tenancy agreement.
		$tenancy->agreements()->save($agreement);

		// Build the rent amount.
		$rent = new TenancyRent();
		$rent->user_id = Auth::user()->id;
		$rent->amount = $data['rent_amount'];
		$rent->starts_at = $agreement->starts_at;

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

	public function createRentAmount()
	{

	}

	public function createTenancyAgreement()
	{

	}
}
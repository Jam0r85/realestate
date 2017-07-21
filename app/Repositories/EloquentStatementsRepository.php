<?php

namespace App\Repositories;

use App\Tenancy;
use App\Statement;
use Carbon\Carbon;

class EloquentStatementsRepository extends EloquentBaseRepository
{
	/**
	 * @var  App\Repositories\EloquentInvoicesRepository
	 */
	public $invoices;

    /**
     * Create a new repository instance.
     * 
     * @param   EloquentPaymentsRepository $payments
     * @return  void
     */
	public function __construct(EloquentInvoicesRepository $invoices)
	{
		$this->invoices = $invoices;
	}

	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Statement';
	}

    /**
     * Get all records in the repo and paginate them.
     *
     * @return mixed
     */
    public function getSentPaged()
    {
        return $this->getInstance()->whereNotNull('sent_at')->with('tenancy','tenancy.property','users')->latest()->paginate();
    }

    /**
     * Get all records in the repo and paginate them.
     *
     * @return mixed
     */
    public function getUnsentPaged()
    {
        return $this->getInstance()->whereNull('sent_at')->orWhereNull('paid_at')->with('tenancy','tenancy.property','users')->latest()->paginate();
    }

	/**
	 * Create a new statement for a tenancy.
	 * 
	 * @param  array  $data
	 * @param  [type] $tenancy [description]
	 * @return [type]          [description]
	 */
	public function createStatement(array $data, $tenancy)
	{
		// Find the tenancy.
		$tenancy = Tenancy::findOrFail($tenancy);

		// Build the data array.
		$data['tenancy_id'] = $tenancy->id;
		$data['key'] = str_random(30);

		// Set the statement amount.
		if (!isset($data['amount'])) {
			$data['amount'] = $tenancy->rent_amount;
		}

		// Set the statement start period.
		if (!isset($data['period_start'])) {
			$data['period_start'] = $tenancy->next_statement_start_date;
		}

		// Set the statement end period.
		if (!isset($data['period_end'])) {
			$data['period_end'] = Carbon::createFromFormat('Y-m-d', $data['period_start'])->addMonth()->subDay();
		}

		$statement = $this->create($data);

		// Attach the property owners to the statement.
		$statement->users()->attach($tenancy->property->owners);

		// Create the service charge invoice should we need to.
		if ($tenancy->service_charge_amount) {

			$invoice = $this->invoices->createInvoice([
				'property_id' => $tenancy->property_id
			]);

			$item = $this->invoices->createInvoiceItem([
				'name' => $tenancy->service->name,
				'description' => $tenancy->service->description,
				'quantity' => 1,
				'amount' => $tenancy->service_charge_amount,
				'tax_rate_id' => $tenancy->service->tax_rate_id
			], $invoice);
		}

		return $statement;
	}
}
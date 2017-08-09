<?php

namespace App\Repositories;

use App\Agreement;
use App\Invoice;
use App\InvoiceGroup;
use App\InvoiceItem;
use App\Payment;
use App\Statement;
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
		$property = new Property();
		$property->user_id = Auth::user()->id;
		$property->fill($data);
		$property->save();

		if (isset($data['owners'])) {
			$property->owners()->attach($data['owners']);
		}

		return $property;
	}

	/**
	 * Store a new rent payment for a tenancy.
	 * 
	 * @param array $data
	 * @param integer $id
	 * @return App\Tenancy
	 */
	public function createRentPayment(array $data, $id)
	{
		$tenancy = Tenancy::findOrFail($id);

		// Store the rent payment.
		$payment = new Payment();
		$payment->key = str_random(30);
		$payment->payment_method_id = $data['payment_method_id'];
		$payment->amount = $data['amount'];

		$payment = $tenancy->rent_payments()->save($payment);

		// Attach the tenants to the payment.
		$payment->users()->attach($tenancy->tenants);

		// Flash a success message.
		$this->successMessage('The payment was recorded');

		// Create a statement if the balance held is enough
		if (isset($data['create_auto_statement'])) {
			if ($tenancy->canCreateStatement()) {
				
				$data = [
					'is_auto' => true
				];

				$this->createStatement($data, $tenancy->id);
			}
		}

		return $tenancy;
	}

	/**
	 * Create a rental statement.
	 * 
	 * @param array $data
	 * @param integer $tenancy_id
	 * @return \App\Statement
	 */
	public function createStatement(array $data, $tenancy_id)
	{
		$tenancy = Tenancy::findOrFail($tenancy_id);

		// Work out the start date if not set.
		if (!isset($data['period_start'])) {
			$data['period_start'] = $tenancy->next_statement_start_date;
		} else {
			$data['period_start'] = Carbon::createFromFormat('Y-m-d', $data['period_start']);
		}

		// Work out the end date of not set.
		if (!isset($data['period_end'])) {
			$data['period_end'] = clone $data['period_start'];
			$data['period_end']->addMonth()->subDay();
		} else {
			$data['period_end'] = Carbon::createFromFormat('Y-m-d', $data['period_end']);
		}

		$statement = new Statement();
		$statement->key = str_random(30);
		$statement->amount = isset($data['amount']) ?? $tenancy->rent_amount;
		$statement->period_start = $data['period_start'];
		$statement->period_end = $data['period_end'];

		$tenancy->statements()->save($statement);

		$this->successMessage('The statement was created');

		$this->createStatementServiceInvoiceItem($statement, $tenancy);

		return $statement;
	}

	/**
	 * Create the service change invoice item and attach it to the statement.
	 * 
	 * @param \App\Statement $statement
	 * @param \App\Tenancy $tenancy
	 * @return void
	 */
	public function createStatementServiceInvoiceItem(Statement $statement, Tenancy $tenancy)
	{
		$this->createStatementInvoiceItem([
			'name' => $tenancy->service->name,
			'description' => $tenancy->service->description,
			'quantity' => 1,
			'amount' => $tenancy->service_charge_amount,
			'tax_rate_id' => $tenancy->service->tax_rate_id
		], $statement);
	}

	/**
	 * Create an invoice item for the given statement.
	 * 
	 * @param array $data
	 * @param \App\Statement $statement
	 * @return void
	 */
	public function createStatementInvoiceItem(array $data, Statement $statement)
	{
		$invoice = $statement->invoice;

		if (!$invoice) {
			$invoice = new Invoice();
			$invoice->user_id = Auth::user()->id;
			$invoice->property_id = $statement->property->id;
			$invoice->key = str_random(30);
			$invoice->invoice_group_id = isset($data['invoice_group_id']) ?: get_setting('invoice_default_group', 0);
			$invoice->number = isset($data['number']) ?: InvoiceGroup::findOrFail($invoice->invoice_group_id)->next_number;

			$invoice = $statement->invoices()->save($invoice);

			InvoiceGroup::find($invoice->invoice_group_id)->increment('next_number');
		}

		$item = new InvoiceItem();
		$item->name = $data['name'];
		$item->description = $data['description'];
		$item->amount = $data['amount'];
		$item->quantity = $data['quantity'];
		$item->tax_rate_id = $data['tax_rate_id'];

		$invoice->items()->save($item);
	}

	/**
	 * Update the discounts in storage for a tenancy.
	 * 
	 * @param array $discounts
	 * @param integer $id
	 * @return \App\Tenancy
	 */
	public function updateDiscounts($discounts = [], $id)
	{
		$tenancy = Tenancy::findOrFail($id);

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
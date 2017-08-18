@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('tenancies.show', $tenancy->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $tenancy->name }}</h1>
			<h2 class="subtitle">Record old statement</h2>

			<hr />

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('tenancies.create-old-rental-statement', $tenancy->id) }}">
				{{ csrf_field() }}

				<div class="columns">
					<div class="column is-6">

						<div class="box mb-2">

							<h3 class="title">Record Rent Payment</h3>
							<h5 class="subtitle">Optional - record a rental payment at the same time.</h5>

							<div class="field">
								<label class="label" for="payment_method_id">Payment Method</label>
								<div class="control">
									<span class="select is-fullwidth">
										<select name="payment_method_id">
											@foreach (payment_methods() as $method)
												<option @if (old('payment_method_id') && old('payment_method_id') == $method->id) selected @endif value="{{ $method->id }}">{{ $method->name }}</option>
											@endforeach
										</select>
									</span>
								</div>
							</div>

							<div class="field">
								<label class="label" for="rent_received">Rent Received</label>
								<div class="control">
									<input type="number" step="any" name="rent_received" class="input" value="{{ old('rent_received') }}" />
								</div>
							</div>

						</div>

						<div class="box mb-2">

							<h3 class="title">Statement Details</h3>
							<h5 class="subtitle">Statement details - The statement recipient, payment method, etc will automatically be selected based on the current property settings.</h5>

							<div class="field">
								<label class="label" for="created_at">Date Created</label>
								<div class="control">
									<input type="date" name="created_at" class="input" value="{{ old('created_at') }}" />
								</div>
							</div>

							<div class="field">
								<label class="label" for="period_start">Date Start</label>
								<div class="control">
									<input type="date" name="period_start" class="input" value="{{ old('period_start') }}" />
								</div>
							</div>

							<div class="field">
								<label class="label" for="period_end">Date End</label>
								<div class="control">
									<input type="date" name="period_end" class="input" value="{{ old('period_end') }}" />
								</div>
							</div>

							<div class="field">
								<label class="label" for="amount">Statement Rent Amount</label>
								<div class="control">
									<input type="number" step="any" name="amount" class="input" value="{{ old('amount') }}" />
								</div>
							</div>

						</div>

					</div>
					<div class="column is-6">

						<div class="box">

							<h3 class="title">Latest Recorded Statements</h3>

							<table class="table is-striped is-fullwidth">
								<thead>
									<th>Date</th>
									<th>Start</th>
									<th>End</th>
									<th>Amount</th>
									<th>Balance</th>
								</thead>
								<tbody>
									@foreach ($tenancy->latest_statements as $statement)
										<tr>
											<td><a href="{{ route('statements.show', $statement->id) }}">{{ date_formatted($statement->created_at) }}</a></td>
											<td>{{ date_formatted($statement->period_start) }}</td>
											<td>{{ date_formatted($statement->period_end) }}</td>
											<td>{{ currency($statement->amount) }}</td>
											<td>{{ currency($statement->landlord_balance_amount) }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>

						</div>

					</div>
				</div>

				<div class="box">

					<h3 class="title">Record Invoice</h3>
					<h5 class="subtitle">Optional - record the invoice for this statement at the same time.</h5>

					<div class="field">
						<label class="label" for="invoice_number">Invoice Number</label>
						<div class="control">
							<input type="number" step="any" name="invoice_number" class="input" />
						</div>
					</div>

					<hr />

					<div class="columns">
						<div class="column is-4">

							<h4 class="subtitle">Invoice Item 1</h4>

							@include('invoices.partials.item-form', ['array' => true])

						</div>
						<div class="column is-4">

							<h4 class="subtitle">Invoice Item 2</h4>

							@include('invoices.partials.item-form', ['array' => true])

						</div>
						<div class="column is-4">

							<h4 class="subtitle">Invoice Item 3</h4>

							@include('invoices.partials.item-form', ['array' => true])

						</div>
					</div>

				</div>

				<div class="box">

					<h3 class="title">Record Expenses</h3>
					<h5 class="subtitle">Optional - record expenses for this statement.</h5>

					<hr />

					<div class="columns">
						<div class="column is-4">

							<h4 class="subtitle">Expense Item 1</h4>

							@include('expenses.partials.form', ['array' => true])

						</div>
						<div class="column is-4">

							<h4 class="subtitle">Expense Item 2</h4>

							@include('expenses.partials.form', ['array' => true])

						</div>
						<div class="column is-4">

							<h4 class="subtitle">Expense Item 3</h4>

							@include('expenses.partials.form', ['array' => true])

						</div>
					</div>

				</div>

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Record Statement
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection
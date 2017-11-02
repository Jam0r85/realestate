@extends('layouts.app')

@section('content')

	<form role="form" method="POST" action="{{ route('tenancies.create-old-rental-statement', $tenancy->id) }}">
		{{ csrf_field() }}

		<section class="section">
			<div class="container">

				<div class="page-title">
					<a href="{{ route('tenancies.show', $tenancy->id) }}" class="btn btn-secondary float-right">
						Return
					</a>
					<h1>{{ $tenancy->name }}</h1>
					<h3 class="text-muted">Record old statement</h3>
				</div>

			</div>
		</section>

		<div class="container">
			@include('partials.errors-block')

			<div class="row">
				<div class="col-5">

					<section class="section">

						<div class="card mb-3">
							<div class="card-header">
								Statement Details
							</div>
							<div class="card-body">

								<div class="form-group">
									<label for="created_at">Date Created</label>
									<input type="date" name="created_at" class="form-control" value="{{ old('created_at') }}" required />
									<small class="form-text text-muted">
										The date of the statement when it was originally created.
									</small>
								</div>

								<div class="form-group">
									<label for="period_start">Date Start</label>
									<input type="date" name="period_start" class="form-control" value="{{ old('period_start') }}" required />
									<small class="form-text text-muted">
										The start date of the statement.
									</small>
								</div>

								<div class="form-group">
									<label for="period_end">Date End</label>
									<input type="date" name="period_end" class="form-control" value="{{ old('period_end') }}" required />
									<small class="form-text text-muted">
										The end date of the statement.
									</small>
								</div>

								<div class="form-group">
									<label for="amount">Amount</label>
									<input type="number" step="any" name="amount" class="form-control" value="{{ old('amount') }}" required />
									<small class="form-text text-muted">
										Enter the rent amount of the statement.
									</small>
								</div>

								<div class="form-group">
									<label for="users">Users</label>
									<select name="users[]" class="form-control select2" multiple>
										@foreach (users() as $user)
											<option value="{{ $user->id }}">{{ $user->name }}</option>
										@endforeach
									</select>
									<small class="form-text text-muted">
										Set the user's of this statement manually of leave blank for it to select the property owners by default.
									</small>
								</div>

							</div>
						</div>

					</section>

					<section class="section">

						<div class="card mb-3">
							<div class="card-header">
								<button type="button" class="btn btn-secondary btn-sm float-right" id="cloneInvoiceItem">
									<i class="fa fa-plus"></i> Invoice Item
								</button>
								Record Invoice &amp; Invoice Items
							</div>
							<div class="card-body">

								<div class="form-group">
									<label for="invoice_number">Invoice Number</label>
									<input type="number" step="any" name="invoice_number" class="form-control" value="{{ old('invoice_number') }}" />
									<small class="form-text text-muted">
										Invoice number is required when adding invoice items.
									</small>
								</div>

								<hr />

								<div id="invoiceItems">
									<div id="invoiceItemColumn">
										<div class="card border-info mb-3">
											<div class="card-header">
												Invoice Item
											</div>
											<div class="card-body">

												@include('invoices.partials.item-form', [
													'array' => true,
													'data' => [
														'name' => 'Full Management',
														'description' => 'Full management service at 10% plus VAT',
														'quantity' => '1',
														'amount' => session('old_statement_management_service_amount')
													]
												])

											</div>
										</div>
									</div>
								</div>

								@component('partials.bootstrap.save-submit-button')
									Record Old Statement
								@endcomponent

							</div>
						</div>

					</section>

					<section class="section">

						<div class="card mb-3">
							<div class="card-header">
								<button type="button" class="btn btn-secondary btn-sm float-right" id="cloneExpenseItem">
									<i class="fa fa-plus"></i> Expense Item
								</button>
								Expense Items
							</div>
							<div class="card-body">

								<div id="expenseItems">
									<div id="expenseItemColumn">
										<div class="card border-warning mb-3">
											<div class="card-header">
												Expense Item
											</div>
											<div class="card-body">

												<div class="form-group">
													<label for="expense_name">Name</label>
													<input class="form-control" type="text" name="expense_name[]" id="expense_name" />
												</div>

												<div class="form-group">
													<label for="expense_cost">Cost</label>
													<input class="form-control" type="number" step="any" name="expese_cost[]" id="expense_cost" />
												</div>

												<div class="form-group">
													<label for="expense_contractors">Contractor</label>
													<select name="expense_contractors[]" id="expense_contractors" class="form-control select2">
														@foreach (users() as $user)
															<option @if ($expense->contractor_id == $user->id) selected @endif value="{{ $user->id }}">
																{{ $user->name }}
															</option>
														@endforeach
													</select>
												</div>

											</div>
										</div>
									</div>
								</div>

								@component('partials.save-button')
									Record Old Statement
								@endcomponent

							</div>
						</div>

					</section>

				</div>
				<div class="col-7">

					<table class="table table-striped table-responsive">
						<thead>
							<th>Date</th>
							<th>Starts</th>
							<th>Ends</th>
							<th>Amount</th>
							<th>Invoice</th>
						</thead>
						<tbody>
							@foreach ($tenancy->statements as $statement)
								<tr>
									<td>
										<a href="{{ route('statements.show', $statement->id) }}" title="Statement #{{ $statement->id }}">
											{{ date_formatted($statement->created_at) }}
										</a>
									</td>
									<td>{{ date_formatted($statement->period_start) }}</td>
									<td>{{ date_formatted($statement->period_end) }}</td>
									<td>{{ currency($statement->amount) }}</td>
									<td>
										@if ($statement->invoice)
											<a href="{{ route('invoices.show', $statement->invoice->id) }}" title="Invoice #{{ $statement->invoice->number }}">
												{{ $statement->invoice->number }}
											</a>
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

				</div>
			</div>

		</div>

	</form>

@endsection

@push('footer_scripts')
<script>
	// Clone an expense item.
	$('#cloneExpenseItem').click(function() {

		var div = $("#expenseItems div"); 

		//find all select2 and destroy them   
		div.find(".select2").each(function(index)
		{
			if ($(this).data('select2')) {
				$(this).select2('destroy');
			} 
		});

		//Now clone you select2 div 
		$('#expenseItemColumn').clone(true).find('input,textarea').val('').end().appendTo("#expenseItems"); 

		//we must have to re-initialize  select2 
		$('.select2').select2(); 
	});

	// Clone an invoice item.
	$('#cloneInvoiceItem').click(function() {
		$('#invoiceItemColumn').clone(true).find('input,textarea').val('').end().appendTo("#invoiceItems"); 
	});
</script>
@endpush
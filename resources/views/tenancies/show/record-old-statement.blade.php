@extends('layouts.app')

@section('content')

	<form method="POST" action="{{ route('tenancies.create-old-rental-statement', $tenancy->id) }}">
		{{ csrf_field() }}

		@component('partials.bootstrap.section-with-container')

			<div class="page-title">

				<a href="{{ route('tenancies.show', $tenancy->id) }}" class="btn btn-secondary float-right">
					Return
				</a>

				@component('partials.header')
					{{ $tenancy->name }}
				@endcomponent

				@component('partials.sub-header')
					Record old statement
				@endcomponent

			</div>

		@endcomponent

		@component('partials.bootstrap.section-with-container')

			@include('partials.errors-block')

			<div class="row">
				<div class="col-5">

					<div class="card mb-3">

						@component('partials.card-header')
							Statement Details
						@endcomponent

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

					@component('partials.save-button')
						Save Changes
					@endcomponent

					<div class="card mt-3 mb-3">

						@component('partials.card-header')
							<button type="button" class="btn btn-secondary btn-sm float-right" id="cloneInvoiceItem">
								<i class="fa fa-plus"></i> Invoice Item
							</button>
							Add Invoice
						@endcomponent

						<div class="card-body">

							<div class="form-group">
								<label for="invoice_number">Invoice Number</label>
								<input type="number" step="any" name="invoice_number" id="invoice_number" class="form-control" value="{{ old('invoice_number') }}" />
								<small class="form-text text-muted">
									Invoice number is required when adding invoice items.
								</small>
							</div>

						</div>

						<div id="invoiceItems">
							<div class="card-body" id="invoiceItemColumn">

								<h5 class="text-info mb-3">Invoice Item</h5>

								<div class="form-group">
									<label for="item_name">Name</label>
									<input type="text" name="item_name[]" class="form-control" required value="{{ $tenancy->service ? $tenancy->service->name : '' }}" />
								</div>

								<div class="form-group">
									<label for="item_description">Description (optional)</label>
									<textarea rows="6" name="item_description[]" class="form-control">{{ $tenancy->service ? $tenancy->service->description : '' }}</textarea>
								</div>

								<div class="form-group">
									<label for="item_amount">Amount Per Item</label>
									<input type="number" step="any" name="item_amount[]" class="form-control" required />
								</div>

								<div class="form-group">
									<label for="item_quantity">Quantity</label>
									<input type="number" name="item_quantity[]" class="form-control" required value="1" />
								</div>

								<div class="form-group">
									<label for="item_tax_rate_id">Tax Rate</label>
									<select name="item_tax_rate_id[]" class="form-control" required>
										<option value="0" selected>None</option>
										@foreach (tax_rates() as $rate)
											<option @if (get_setting('default_tax_rate_id') == $rate->id) selected @endif value="{{ $rate->id }}">
												{{ $rate->name }}
											</option>
										@endforeach
									</select>
								</div>

							</div>
						</div>

					</div>

					@component('partials.save-button')
						Save Changes
					@endcomponent

					<div class="card mt-3 mb-3">

						@component('partials.card-header')
							<button type="button" class="btn btn-secondary btn-sm float-right" id="cloneExpenseItem">
								<i class="fa fa-plus"></i> Expense Item
							</button>
							Expense Items
						@endcomponent

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
														<option value="{{ $user->id }}">
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

		@endcomponent

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
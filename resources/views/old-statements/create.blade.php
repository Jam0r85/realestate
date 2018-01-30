@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Tenancy
				@slot('url')
					{{ route('tenancies.show', $tenancy->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Record Old Statement
		@endcomponent

		@component('partials.sub-header')
			{{ $tenancy->present()->name }}
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('old-statements.store', $tenancy->id) }}">
			{{ csrf_field() }}

			<div class="row">
				<div class="col-12 col-lg-6">

					@component('partials.card')
						@slot('header')
							Statement Details
						@endslot
						@slot('body')

							@component('partials.form-group')
								@slot('label')
									Statement Date
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" name="created_at" id="created_at" class="form-control" value="{{ old('created_at') }}" />
								@endcomponent
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Period From
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" name="period_start" id="period_start" class="form-control" value="{{ old('period_start') }}" />
								@endcomponent
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Period Until
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" name="period_end" id="period_end" class="form-control" value="{{ old('period_end') }}" />
								@endcomponent
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Statement Amount
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('money')
									@endslot
									<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" />
								@endcomponent
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Attached Users
								@endslot
								<select name="users[]" id="users" class="form-control select2" multiple>
									@foreach (common('users') as $user)
										<option @if ($tenancy->property->owners->contains($user->id)) selected @endif value="{{ $user->id }}">
											{{ $user->present()->selectName }}
										</option>
									@endforeach
								</select>
							@endcomponent

						@endslot
						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot
					@endcomponent

					{{-- Invoice Items --}}

					@component('partials.card')
						@slot('header')
							Create Invoice
						@endslot
						@slot('body')
							<p class="card-text">
								You can create an invoice and attach it to the statement by entering the details.
							</p>

							@component('partials.form-group')
								@slot('label')
									Invoice Number
								@endslot
								<input type="text" name="invoice_number" id="invoice_number" class="form-control" value="{{ old('invoice_number') }}" />
							@endcomponent

						@endslot

						<div id="invoiceItems">
							<div class="card-body" id="invoiceItemColumn">

								<h5 class="bg-info text-white p-3 mb-3">Invoice Item</h5>

								<div class="form-group">
									<label for="item_name">Name</label>
									<input type="text" name="item_name[]" class="form-control" value="{{ $tenancy->service ? $tenancy->service->name : '' }}" />
								</div>

								<div class="form-group">
									<label for="item_description">Description (optional)</label>
									<textarea rows="6" name="item_description[]" class="form-control">{{ $tenancy->service ? $tenancy->service->description : '' }}</textarea>
								</div>

								<div class="form-group">
									<label for="item_amount">Amount Per Item</label>
									<input type="number" step="any" name="item_amount[]" class="form-control" />
								</div>

								<div class="form-group">
									<label for="item_quantity">Quantity</label>
									<input type="number" name="item_quantity[]" class="form-control" value="1" />
								</div>

								<div class="form-group">
									<label for="item_tax_rate_id">Tax Rate</label>
									<select name="item_tax_rate_id[]" class="form-control">
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

						@slot('footer')
							<button type="button" class="btn btn-secondary" id="cloneInvoiceItem">
								<i class="fa fa-plus"></i> Invoice Item
							</button>
						@endslot
					@endcomponent

					{{-- Expense Items --}}

					<div class="card mb-3">
						@component('partials.card-header')
							Expense Items
						@endcomponent

						<div id="expenseItems">
							<div id="expenseItemColumn" class="card-body">

								<h5 class="bg-primary text-white p-3 mb-3">Expense Item</h5>

								<div class="form-group">
									<label for="expense_name">Name</label>
									<input class="form-control" type="text" name="expense_name[]" id="expense_name" />
								</div>

								<div class="form-group">
									<label for="expense_cost">Cost</label>
									<input class="form-control" type="number" step="any" name="expense_cost[]" id="expense_cost" />
								</div>

								<div class="form-group">
									<label for="expense_contractor">Contractor</label>
									<select name="expense_contractor_id[]" id="expense_contractor_id" class="form-control select2">
										@foreach (users() as $user)
											<option value="{{ $user->id }}">
												{{ $user->name }}
											</option>
										@endforeach
									</select>
								</div>

							</div>

						</div>
						<div class="card-footer">

							<button type="button" class="btn btn-secondary" id="cloneExpenseItem">
								<i class="fa fa-plus"></i> Expense Item
							</button>
						</div>
					</div>

				</div>
				<div class="col-12 col-lg-6">


				</div>
			</div>

		</form>

	@endcomponent

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
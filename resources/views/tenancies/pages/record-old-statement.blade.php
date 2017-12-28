@extends('layouts.app')

@section('content')

	<form method="POST" action="{{ route('old-statement.store') }}">
		{{ csrf_field() }}
		<input type="hidden" name="tenancy_id" value="{{ $tenancy->id }}" />

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



						</div>
					</div>

					@component('partials.save-button')
						Save Changes
					@endcomponent

					

					@component('partials.save-button')
						Save Changes
					@endcomponent



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
@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Starts</th>
		<th>Ends</th>
		@if (!isset($tenancy))
			<th>Tenancy</th>
			<th>Property</th>
		@endif
		<th>Amount</th>
		@if (isset($tenancy))
			<th>Landlord</th>
			<th>Invoice</th>
		@endif
		@if (!request('sent'))
			<th>Send By</th>
		@endif
		<th></th>
	@endslot
	@slot('body')
		@foreach ($statements as $statement)
			<tr>
				<td>{{ $statement->present()->statusWithDate() }}</td>
				<td>{{ date_formatted($statement->period_start) }}</td>
				<td>{{ date_formatted($statement->period_end) }}</a></td>
				@if (!isset($tenancy))
					<td>{{ truncate($statement->present()->tenancyName) }}</td>
					<td>{{ truncate($statement->present()->propertyAddress) }}</td>
				@endif
				<td>{{ $statement->present()->amountFormatted }}</td>
				@if (isset($tenancy))
					<td>{{ currency($statement->present()->landlordBalanceTotal) }}</td>
					<td>
						@if (count($statement->invoices))
							@foreach ($statement->invoices as $invoice)
								{{ $invoice->present()->name }}
							@endforeach
						@endif
					</td>
				@endif
				@if (!request('sent'))
					<td>{{ $statement->present()->sendBy(null) }}</td>
				@endif
				<td class="text-right text-nowrap">
						
					{{-- Send the Statement Form --}}
					@if ($statement->present()->status == 'Paid')
						<form method="POST" action="{{ route('statements.send', $statement->id) }}" class="d-inline">
							{{ csrf_field() }}
							<button type="submit" class="btn btn-info btn-sm">
								@icon('sent')
							</button>
						</form>
					@endif

					<a href="{{ route('statements.show', $statement->id) }}" class="btn btn-primary btn-sm">
						View
					</a>

				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
@component('partials.table')
	@slot('header')
		@if (isset($unsent))
			<th>Status</th>
		@endif
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
		@if (isset($unsent))
			<th>Send By</th>
		@endif
		<th></th>
	@endslot
	@slot('body')
		@foreach ($statements as $statement)
			<tr>
				@if (isset($unsent))
					<td>{{ $statement->present()->statusWithDate() }}</td>
				@endif
				<td>{{ date_formatted($statement->period_start) }}</td>
				<td>{{ date_formatted($statement->period_end) }}</a></td>
				@if (!isset($tenancy))
					<td>
						<a href="{{ route('tenancies.show', $statement->tenancy->id) }}">
							{{ $statement->present()->tenancyName }}
						</a>
					</td>
					<td>{{ $statement->present()->propertyAddress }}</td>
				@endif
				<td>{{ $statement->present()->amountFormatted }}</td>
				@if (isset($tenancy))
					<td>{{ currency($statement->getLandlordAmount()) }}</td>
					<td>
						@if (count($statement->invoices))
							@foreach ($statement->invoices as $invoice)
								{{ $invoice->present()->name }}
							@endforeach
						@endif
					</td>
				@endif
				@if (isset($unsent))
					<td>{{ $statement->present()->sendBy(null) }}</td>
				@endif
				<td class="text-right text-nowrap">
					@include('statements.partials.statements-table-action-buttons')
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
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
		<th>Send By</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($statements as $statement)
			<tr>
				<td>{{ $statement->present()->statusWithDate() }}</td>
				<td>
					<a href="{{ route('statements.show', $statement->id) }}">
						{{ date_formatted($statement->period_start) }}
					</a>
				</td>
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
					<td>{{ $statement->invoice() ? $statement->invoice()->number : '-' }}</td>	
				@endif
				<td>{{ $statement->present()->sendBy(null) }}</td>
				<td class="text-right">
					@if ($statement->present()->status == 'Paid')
						<form method="POST" action="{{ route('statements.send', $statement->id) }}" class="d-inline">
							{{ csrf_field() }}
							<button type="submit" class="btn btn-info btn-sm">
								Send
							</button>
						</form>
					@endif
					<a href="{{ route('downloads.statement', $statement->id) }}" class="btn btn-primary btn-sm" target="_blank">
						Download
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
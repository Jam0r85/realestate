@component('partials.table')
	@slot('header')
		<th>Starts</th>
		<th>Ends</th>
		<th>Tenancy</th>
		<th>Property</th>
		<th>Amount</th>
		<th>Sent</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($statements as $statement)
			<tr>
				<td>
					<a href="{{ route('statements.show', $statement->id) }}" title="Statement #{{ $statement->id }}">
						{{ date_formatted($statement->period_start) }}
					</a>
				</td>
				<td>{{ date_formatted($statement->period_end) }}</a>
				<td>
					<a href="{{ route('tenancies.show', $statement->tenancy->id) }}">
						{{ $statement->tenancy->present()->name }}
					</a>
				</td>
				<td>{{ $statement->tenancy->property->present()->shortAddress }}</td>
				<td>{{ currency($statement->amount) }}</td>
				<td>{{ date_formatted($statement->sent_at) }}</td>
				<td class="text-right">
					<a href="{{ route('downloads.statement', $statement->id) }}" class="btn btn-primary btn-sm" target="_blank">
						Download
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent

@include('partials.pagination', ['collection' => $statements])
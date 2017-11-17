@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Starts</th>
		<th>Ends</th>
		<th>Tenancy</th>
		<th>Property</th>
		<th>Amount</th>
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
				<td>{{ date_formatted($statement->period_end) }}</a>
				<td>
					<a href="{{ route('tenancies.show', $statement->tenancy->id) }}">
						{{ $statement->present()->tenancyName }}
					</a>
				</td>
				<td>{{ $statement->present()->propertyAddress }}</td>
				<td>{{ currency($statement->amount) }}</td>
				<td>{{ $statement->present()->sendBy(null) }}</td>
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
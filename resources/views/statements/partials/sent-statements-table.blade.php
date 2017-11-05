@component('partials.table')
	@slot('header')
		<th>Starts</th>
		<th>Ends</th>
		<th>Tenancy</th>
		<th>Property</th>
		<th>Amount</th>
		<th>Sent</th>
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
					<a href="{{ route('tenancies.show', $statement->tenancy->id) }}" title="{{ $statement->tenancy->name }}">
						{!! truncate($statement->tenancy->name) !!}
					</a>
				</td>
				<td>{!! truncate($statement->property->short_name) !!}</td>
				</td>
				<td>{{ currency($statement->amount) }}</td>
				<td>{{ date_formatted($statement->sent_at) }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent

@include('partials.pagination', ['collection' => $statements])
@component('partials.table')
	@slot('head')
		<th>Tenancy &amp; Property</th>
		<th>Period</th>
		<th>Amount</th>
		<th>Date</th>
		<th>Status</th>
	@endslot
	@foreach ($statements as $statement)
		<tr>
			<td>
				{{ $statement->property->short_name }}
				<br />
				<a href="{{ route('tenancies.show', $statement->tenancy->id) }}">
					<span class="tag is-primary">
						{{ $statement->tenancy->name }}
					</span>
				</a>
			</td>
			<td>
				<a href="{{ route('statements.show', $statement->id) }}">{{ date_formatted($statement->period_start) }} - {{ date_formatted($statement->period_end) }}</a>
			</td>
			<td>{{ currency($statement->amount) }}</td>
			<td>{{ date_formatted($statement->created_at) }}</td>
			<td>
				@if ($statement->sent_at)
					Sent {{ date_formatted($statement->sent_at) }}
				@else
					@if ($statement->paid_at)
						Paid
					@else
						Unpaid
					@endif
				@endif
			</td>
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $statements])
@component('partials.table')
	@slot('head')
		<th></th>
		<th>Date</th>
		<th>Tenancy &amp; Property</th>
		<th>Amount</th>
		<th>Period</th>
		<th>Status</th>
	@endslot
	@foreach ($statements as $statement)
		<tr>
			<td>
				<label class="checkbox">
					<input type="checkbox" name="statement_id[]" value="{{ $statement->id }}" />
				</label>
			</td>
			<td>{{ date_formatted($statement->created_at) }}</td>
			<td>
				{{ $statement->tenancy->name }}
				<br />
				<a href="{{ route('properties.show', $statement->property->id) }}">
					<span class="tag is-light">
						{{ $statement->property->short_name }}
					</span>
				</a>
			</td>
			<td>{{ currency($statement->amount) }}</td>
			<td><a href="{{ route('statements.show', $statement->id) }}">{{ date_formatted($statement->period_start) }} - {{ date_formatted($statement->period_end) }}</a></td>
			<td>
				@if ($statement->sent_at)
					Sent
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
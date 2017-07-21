@component('partials.table')
	@slot('head')
		<th>Tenancy</th>
		<th>Property</th>
		<th>Amount</th>
		<th>Period</th>
		<th>Status</th>
		<th>User(s)</th>
	@endslot
	@foreach ($statements as $statement)
		<tr>
			<td>{{ $statement->tenancy->name }}</td>
			<td>{{ $statement->tenancy->property->short_name }}</td>
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
			<td>
				@foreach ($statement->users as $user)
					<a href="{{ route('users.show', $user->id) }}">
						<span class="tag is-primary">
							{{ $user->name }}
						</span>
					</a>
				@endforeach
			</td>
		</tr>
	@endforeach
@endcomponent
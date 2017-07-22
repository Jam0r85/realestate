@component('partials.table')
	@slot('head')
		@if (isset($show_tenancy))
			<th>Tenancy</th>
		@endif
		@if (isset($show_property))
			<th>Property</th>
		@endif
		<th>Amount</th>
		<th>Period</th>
		<th>Status</th>
		@if (isset($show_download))
			<th>Statement</th>
		@endif
		<th>User(s)</th>
	@endslot
	@foreach ($statements as $statement)
		<tr>
			@if (isset($show_tenancy))
				<td>{{ $statement->tenancy->name }}</td>
			@endif
			@if (isset($show_property))
				<td>{{ $statement->tenancy->property->short_name }}</td>
			@endif
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
			@if (isset($show_download))
				<td><a href="{{ route('downloads.statement', $statement->id) }}" target="_blank">Download</a></td>
			@endif
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

@include('partials.pagination', ['collection' => $statements])
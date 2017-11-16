	@component('partials.table')
		@slot('header')
			<th>Status</th>
			<th>Start</th>
			<th>End</th>
			<th>Tenancy &amp; Property</th>
			<th>Send By</th>
			<th>Recipients</th>
		@endslot
		@slot('body')
			@foreach ($statements as $statement)
				<tr>
					<td>
						@if ($statement->isUnpaid())
							<span class="badge badge-danger">
								Unpaid
							</span>
						@else
							<span class="badge badge-success">
								Ready
							</span>
						@endif
					</td>
					<td>
						<a href="{{ route('statements.show', $statement->id) }}">
							{{ date_formatted($statement->period_start) }}
						</a>
					</td>
					<td>{{ date_formatted($statement->period_end) }}</td>
					<td>{{ $statement->tenancy->present()->name }}
						<br />
						<a href="{{ route('properties.show', $statement->property->id) }}">
							<small>{{ $statement->tenancy->property->present()->shortAddress }}</small>
						</a>
					</td>
					<td>{{ $statement->present()->sendBy(null) }}</td>
					<td>
						@include('partials.bootstrap.users-inline', ['users' => $statement->users])
					</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent
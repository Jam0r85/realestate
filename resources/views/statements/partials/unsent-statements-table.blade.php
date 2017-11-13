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
						@if ($statement->hasBeenQueuedToSend())
							<span class="badge badge-info">
								Queued
							</span>
						@endif
						@if ($statement->paid_at)
							<span class="badge badge-success">
								Ready
							</span>
						@else
							<span class="badge badge-danger">
								Unpaid
							</span>
						@endif
					</td>
					<td>
						<a href="{{ route('statements.show', $statement->id) }}" title="Statement #{{ $statement->id }}">
							{{ date_formatted($statement->period_start) }}
						</a>
					</td>
					<td>{{ date_formatted($statement->period_end) }}</td>
					<td>
						{!! truncate($statement->tenancy->name) !!}
						<br />
						<a href="{{ route('properties.show', $statement->property->id) }}">
							<span class="tag is-light">
								{!! truncate($statement->property->short_name) !!}
							</span>
						</a>
					</td>
					<td>{{ ucwords($statement->send_by) }}</td>
					<td>
						@include('partials.bootstrap.users-inline', ['users' => $statement->users])
					</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent
@component('partials.table')
	@slot('head')
		<th></th>
		<th>Date</th>
		<th>Tenancy &amp; Property</th>
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
			<td>
				<label class="checkbox">
					<input type="checkbox" name="statement_id[]" value="{{ $statement->id }}" />
				</label>
			</td>
			<td>{{ date_formatted($statement->created_at) }}</td>
			<td>
				{{ $statement->tenancy->name }}
				<br />
				<span class="tag is-primary">
					{{ $statement->tenancy->property->short_name }}
				</span>
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
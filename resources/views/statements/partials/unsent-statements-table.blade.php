<form role="form" method="POST" action="{{ route('statements.send') }}">
	{{ csrf_field() }}

	<table class="table table-striped table-responsive">
		<thead>
			<th>Status</th>
			<th>Start</th>
			<th>End</th>
			<th>Tenancy &amp; Property</th>
			<th>Send By</th>
			<th>E-Mails</th>
		</thead>
		<tbody>
			@foreach ($statements as $statement)
				<tr>
					<td>
						@if ($statement->paid_at)
							<label class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" name="statements[]" value="{{ $statement->id }}" />
								<span class="custom-control-indicator"></span>
								<span class=-"custom-control-description">Send?</span>
							</label>
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
						<div class="text-truncate">
							{{ $statement->tenancy->name }}
						</div>
						<br />
						<a href="{{ route('properties.show', $statement->property->id) }}">
							<span class="tag is-light">
								{{ $statement->property->short_name }}
							</span>
						</a>
					</td>
					<td>{{ $statement->sendByPost() ? 'Post' : 'E-Mail' }}</td>
					<td>
						@if (count($statement->users))
							@foreach ($statement->users as $user)
								@if ($user->email)
									<span class="badge badge-primary">
										{{ $user->email }}
									</span>
								@endif
							@endforeach
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<button type="submit" class="btn btn-primary">
		<i class="fa fa-envelope-open"></i> Send Statements
	</button>

</form>
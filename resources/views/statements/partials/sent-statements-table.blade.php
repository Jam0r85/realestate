<table class="table table-striped table-responsive">
	<thead>
		<th>Tenancy</th>
		<th>Property</th>
		<th>Starts</th>
		<th>Ends</th>
		<th>Amount</th>
		<th>Sent</th>
	</thead>
	<tbody>
		@foreach ($statements as $statement)
			<tr>
				<td>
					<a href="{{ route('tenancies.show', $statement->tenancy->id) }}">
						{!! truncate($statement->tenancy->name, '200px') !!}
					</a>
				</td>
				<td>{!! truncate($statement->property->short_name) !!}</td>
				<td>
					<a href="{{ route('statements.show', $statement->id) }}">
						{{ date_formatted($statement->period_start) }}
					</a>
				</td>
				<td>{{ date_formatted($statement->period_end) }}</a>
				</td>
				<td>{{ currency($statement->amount) }}</td>
				<td>{{ date_formatted($statement->sent_at) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $statements])
<table class="table table-striped table-responsive">
	<thead>
		<th>Date</th>
		<th>Statement</th>
		<th>Statement Date</th>
		<th>Tenancy</th>
		<th>Amount</th>
	</thead>
	<tbody>
		@foreach ($expense->statements as $statement)
			<tr>
				<td>{{ date_formatted($statement->created_at) }}</td>
				<td>
					<a href="{{ route('statements.show', $statement->id) }}">
						#{{ $statement->id }}
					</a>
				</td>
				<td>{{ date_formatted($statement->period_start) }} - {{ date_formatted($statement->period_end) }}</td>
				<td>{{ $statement->tenancy->name }}</td>
				<td>{{ currency($statement->pivot->amount) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
<table class="table is-fullwidth is-striped">
	<thead>
		<th>Created</th>
		<th>Starts</th>
		<th>Ends</th>
		<th>Tenancy</th>
		<th>Amount</th>
	</thead>
	<tbody>
		@foreach ($property->statements()->limit(15)->get() as $statement)
			<tr>
				<td>
					<a href="{{ route('statements.show', $statement->id) }}" title="Statement #{{ $statement->id }}">
						{{ date_formatted($statement->created_at) }}
					</a>
				</td>
				<td>{{ date_formatted($statement->period_start) }}</td>
				<td>{{ date_formatted($statement->period_end) }}</td>
				<td>{{ $statement->tenancy->name }}</td>
				<td>{{ currency($statement->amount) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
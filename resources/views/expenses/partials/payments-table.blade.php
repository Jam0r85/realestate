<table class="table table-striped table-responsive">
	<thead>
		<th>Date</th>
		<th>Statement</th>
		<th>Amount</th>
	</thead>
	<tbody>
		@foreach ($expense->statements as $statement)
			<tr>
				<td>{{ date_formatted($statement->created_at) }}</td>
				<td>
					<a href="{{ route('statements.show', $statement->id) }}">
						Statement #{{ $statement->id }}
					</a>
				</td>
				<td>{{ currency($statement->pivot->amount) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
<table class="table table-striped table-responsive">
	<thead>
		<th>Name</th>
		<th>Property</th>
		<th>Cost</th>
		<th>Balance</th>
		<th>Date</th>
		<th>Status</th>
	</thead>
	<tbody>
		@foreach ($user->expenses()->limit(5)->get() as $expense)
			<tr>
				<td>
					<a href="{{ route('expenses.show', $expense->id) }}" title="{{ $expense->name }}">
						{{ $expense->name }}
					</a>
				</td>
				<td>{{ $expense->property->short_name }}</td>
				<td>{{ currency($expense->cost) }}</td>
				<td>{{ currency($expense->balance_amount) }}</td>
				<td>{{ date_formatted($expense->created_at) }}</td>
				<td></td>
			</tr>
		@endforeach
	</tbody>
</table>
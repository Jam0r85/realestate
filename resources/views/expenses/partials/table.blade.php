<table class="table is-striped is-fullwidth">
	<thead>
		<th>Name</th>
		<th>Contractors</th>
		<th>Property</th>
		<th>Cost</th>
		<th>Balance</th>
	</thead>
	<tbody>
		@foreach ($expenses as $expense)
			<tr>
				<td>{{ $expense->name }}</td>
				<td>
					@foreach ($expense->contractors as $user)
						<a href="{{ route('users.show', $user->id) }}">
							<span class="tag is-primary">
								{{ $user->name }}
							</span>
						</a>
					@endforeach
				</td>
				<td>{{ $expense->property }}</td>
				<td>{{ currency($expense->cost) }}</td>
				<td>{{ currency($expense->balance_amount) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $expenses])
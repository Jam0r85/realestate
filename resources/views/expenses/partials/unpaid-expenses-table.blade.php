<table class="table table-striped table-responsive">
	<thead>
		<th>Name</th>
		<th>Property</th>
		<th>Contractors</th>
		<th>Cost</th>
		<th>Balance</th>
		<th><i class="fa fa-upload"></i></th>
	</thead>
	<tbody>
		@foreach ($expenses as $expense)
			<tr>
				<td class="text-truncate">
					<a href="{{ route('expenses.show', $expense->id) }}">
						{{ $expense->name }}
					</a>
				</td>
				<td>
					<a href="{{ route('properties.show', $expense->property->id) }}" title="{{ $expense->property->short_name }}">
						{{ $expense->property->short_name }}
					</a>
				</td>
				<td>
					@foreach ($expense->contractors as $user)
						<a href="{{ route('users.show', $user->id) }}" class="badge badge-primary">
							{{ $user->name }}
						</a>
					@endforeach
				</td>
				<td>{{ currency($expense->cost) }}</td>
				<td>{{ currency($expense->balance_amount) }}</td>
				<td>
					@if ($expense->hasInvoice())
						<i class="fa fa-check"></i>
					@endif
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
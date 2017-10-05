<table class="table table-striped table-responsive">
	<thead>
		<th>Name</th>
		<th>Property</th>
		<th>Contractors</th>
		<th>Cost</th>
		<th>Paid</th>
		<th><i class="fa fa-upload"></i></th>
	</thead>
	<tbody>
		@foreach ($expenses as $expense)
			<tr>
				<td>
					<a href="{{ route('expenses.show', $expense->id) }}" title="{{ $expense->name }}">
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
						<a href="{{ route('users.show', $user->id) }}" class="badge badge-primary" title="{{ $user->name }}">
							{{ $user->name }}
						</a>
					@endforeach
				</td>
				<td>{{ currency($expense->cost) }}</td>
				<td>{{ date_formatted($expense->paid_at) }}</td>
				<td>
					@if (count($expense->invoices))
						<i class="fa fa-check"></i>
					@endif
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $expenses])
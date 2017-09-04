<table class="table table-striped table-responsive">
	<thead>
		<th>Name</th>
		<th>Contractors</th>
		<th>Property</th>
		<th>Cost</th>
		<th>Invoice(s)</th>
	</thead>
	<tbody>
		@foreach ($expenses as $expense)
			<tr>
				<td>
					<a href="{{ route('expenses.show', $expense->id) }}">
						{{ $expense->name }}
					</a>
				</td>
				<td>
					@foreach ($expense->contractors as $user)
						<a href="{{ route('users.show', $user->id) }}">
							<span class="tag is-primary">
								{{ $user->name }}
							</span>
						</a>
					@endforeach
				</td>
				<td><a href="{{ route('properties.show', $expense->property->id) }}">{{ $expense->property->short_name }}</a></td>
				<td>{{ currency($expense->cost) }}</td>
				<td>
					@if ($expense->hasInvoice())
						<span class="tag is-success">
							Yes
						</span>
					@else
						<span class="tag is-warning">
							No
						</span>
					@endif
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
<table class="table table-striped table-responsive">
	<thead>
		<th>Number</th>
		<th>Date</th>
		<th>Property</th>
		<th>Total</th>
		<th>Users</th>
	</thead>
	<tbody>
		@foreach ($invoices as $invoice)
			<tr>
				<td>
					<a href="{{ route('invoices.show', $invoice->id) }}" title="{{ $invoice->number }}">
						{{ $invoice->number }}
					</a>
				</td>
				<td>{{ date_formatted($invoice->created_at) }}</td>
				<td>{{ $invoice->property->short_name }}</td>
				<td>{{ currency($invoice->total) }}</td>
				<td>
					@foreach ($invoice->users as $user)
						<a class="badge badge-primary" href="{{ route('users.show', $user->id) }}" title="{{ $user->name }}">
							{{ $user->name }}
						</a>
					@endforeach
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $invoices])
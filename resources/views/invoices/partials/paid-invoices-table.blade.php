<table class="table table-striped table-responsive">
	<thead>
		<th>Number</th>
		<th>Date</th>
		<th>Property</th>
		<th>Total</th>
		<th>Users</th>
		<th>Paid</th>
	</thead>
	<tbody>
		@foreach ($invoices as $invoice)
			<tr>
				<td>
					<a href="{{ route('invoices.show', $invoice->id) }}" title="{{ $invoice->number }}">
						{{ $invoice->name }}
					</a>
				</td>
				<td>{{ date_formatted($invoice->created_at) }}</td>
				<td>{!! $invoice->property ? truncate($invoice->property->short_name) : '-' !!}</td>
				<td>{!! $invoice->trashed() ? '<span class="text-muted"><i class="fa fa-archive"></i> Archived</span>' : currency($invoice->total) !!}</td>
				<td>
					@foreach ($invoice->users as $user)
						<a class="badge badge-primary" href="{{ route('users.show', $user->id) }}" title="{{ $user->name }}">
							{{ $user->name }}
						</a>
					@endforeach
				</td>
				<td>{{ date_formatted($invoice->paid_at) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $invoices])
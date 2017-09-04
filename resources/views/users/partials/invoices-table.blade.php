<table class="table table-striped table-responsive">
	<thead>
		<th>Number</th>
		<th>Property</th>
		<th>Amount</th>
		<th>Balance</th>
		<th>Date</th>
		<th>Status</th>
	</thead>
	<tbody>
		@foreach ($user->invoices()->limit(5)->get() as $invoice)
			<tr>
				<td>
					<a href="{{ route('invoices.show', $invoice->id) }}" title="{{ $invoice->number }}">
						{{ $invoice->number }}
					</a>
				</td>
				<td>{{ $invoice->property->short_name }}</td>
				<td>{{ currency($invoice->total) }}</td>
				<td>{{ currency($invoice->total_balance) }}</td>
				<td>{{ date_formatted($invoice->created_at) }}</td>
				<td></td>
			</tr>
		@endforeach
	</tbody>
</table>
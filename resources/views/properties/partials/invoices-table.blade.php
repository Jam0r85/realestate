<table class="table is-fullwidth is-striped">
	<thead>
		<th>Number</th>
		<th>Total</th>
		<th>Created</th>
		<th>Status</th>
	</thead>
	<tbody>
		@foreach ($property->invoices()->limit(15)->get() as $invoice)
			<tr>
				<td>
					<a href="{{ route('invoices.show', $invoice->id) }}" title="{{ $invoice->number }}">
						{{ $invoice->number }}
					</a>
				</td>
				<td>{{ currency($invoice->total) }}</td>
				<td>{{ date_formatted($invoice->created_at) }}</td>
				<td>{{ $invoice->paid_at ? 'Paid' : 'Unpaid' }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
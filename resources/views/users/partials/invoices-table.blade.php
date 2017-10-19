<table class="table table-striped table-responsive">
	<thead>
		<th>Number</th>
		<th>Property</th>
		<th>Amount</th>
		<th>Balance</th>
		<th>Date</th>
		<th>Status</th>
		<th></th>
	</thead>
	<tbody>
		@foreach ($user->invoices()->limit(15)->get() as $invoice)
			<tr>
				<td>
					<a href="{{ route('invoices.show', $invoice->id) }}" title="{{ $invoice->number }}">
						{{ $invoice->number }}
					</a>
				</td>
				<td>{{ $invoice->property ? $invoice->property->short_name : '-' }}</td>
				<td>{{ currency($invoice->total) }}</td>
				<td>{{ currency($invoice->total_balance) }}</td>
				<td>{{ date_formatted($invoice->created_at) }}</td>
				<td>
					@if ($invoice->total_balance <= 0)
						<span class="badge badge-success">
							Paid
						</span>
					@endif
					@if ($invoice->total_balance > 0)
						<span class="badge badge-danger">
							Unpaid
						</span>
					@endif
				</td>
				<td class="text-right">
					<a href="{{ route('downloads.invoice', $invoice->id) }}" title="Download invoice" target="_blank">
						Download
					</a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
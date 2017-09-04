<table class="table table-striped table-responsive">
	<thead>
		<th>Number</th>
		<th>Amount</th>
		<th>Balance</th>
		<th>Date</th>
	</thead>
	<tbody>
		@foreach ($user->invoices()->limit(5)->get() as $invoice)
			<tr>
				<td><a href="{{ route('invoices.show', $invoice->id) }}">{{ $invoice->number }}</a></td>
				<td>{{ currency($invoice->total) }}</td>
				<td>{{ currency($invoice->total_balance) }}</td>
				<td>{{ date_formatted($invoice->created_at) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
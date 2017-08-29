<table class="table is-striped is-bordered is-fullwidth">
	<thead>
		<th>Number</th>
		<th>Property</th>
		<th>Amount</th>
		<th>
			<input type="checkbox" name="invoice_all" >
		</th>
	</thead>
	<tbody>
		@foreach ($payments as $payment)
			<tr>
				<td width="10%">{{ $payment->parent->number }}</td>
				<td width="80%">{{ $payment->statement->property->short_name }}</td>
				<td width="10%">{{ currency($payment->amount) }}</td>
				<td class="has-text-right"><input type="checkbox" name="payments[]" value="{{ $payment->id }}" /></td>
			</tr>
		@endforeach
	</tbody>
</table>
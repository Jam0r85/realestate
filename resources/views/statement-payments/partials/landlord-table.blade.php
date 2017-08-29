<table class="table is-striped is-bordered is-fullwidth">
	<thead>
		<th>Landlord</th>
		<th>Property</th>
		<th>Method</th>
		<th>Amount</th>
		<th>
			<input type="checkbox" name="landlord_all" >
		</th>
	</thead>
	<tbody>
		@foreach ($payments as $payment)
			<tr>
				<td></td>
				<td>{{ $payment->statement->property->short_name }}</td>
				<td>{{ $payment->method_formatted }}</td>
				<td>{{ currency($payment->amount) }}</td>
				<td class="has-text-right"><input type="checkbox" name="payments[]" value="{{ $payment->id }}" /></td>
			</tr>
		@endforeach
	</tbody>
</table>
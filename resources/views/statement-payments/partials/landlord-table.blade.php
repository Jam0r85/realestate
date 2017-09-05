<table class="table table-striped table-responsive">
	<thead>
		<th>Landlord</th>
		<th>Property</th>
		<th>Method</th>
		<th class="text-right">Amount</th>
		<th>

		</th>
	</thead>
	<tbody>
		@foreach ($payments as $payment)
			<tr>
				<td></td>
				<td>{{ $payment->statement->property->short_name }}</td>
				<td>{{ $payment->method_formatted }}</td>
				<td class="text-right">{{ currency($payment->amount) }}</td>
				<td class="text-right">
					<input type="checkbox" name="payments[]" value="{{ $payment->id }}" />
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
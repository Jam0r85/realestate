<table class="table table-striped table-responsive">
	<thead>
		<th>Property</th>
		<th>Number</th>
		<th class="text-right">Amount</th>
		<th>

		</th>
	</thead>
	<tbody>
		@foreach ($payments as $payment)
			<tr>
				<td>{{ $payment->statement->property->short_name }}</td>
				<td>{{ $payment->parent->number }}</td>
				<td class="text-right">{{ currency($payment->amount) }}</td>
				<td class="text-right">
					<input type="checkbox" name="payments[]" value="{{ $payment->id }}" />
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
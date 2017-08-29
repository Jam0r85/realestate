<table class="table is-striped is-bordered is-fullwidth">
	<thead>
		<th>Property</th>
		<th>Expense</th>
		<th>Amount</th>
		<th>
			<input type="checkbox" name="expense_all" >
		</th>
	</thead>
	<tbody>
		@foreach ($payments as $payment)
			<tr>
				<td>{{ $payment->statement->property->short_name }}</td>
				<td>{!! $payment->parent->statement_name !!}</td>
				<td>{{ currency($payment->amount) }}</td>
				<td class="has-text-right"><input type="checkbox" name="payments[]" value="{{ $payment->id }}" /></td>
			</tr>
		@endforeach
	</tbody>
</table>
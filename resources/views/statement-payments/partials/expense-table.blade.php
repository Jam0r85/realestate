@component('partials.table')
	@slot('head')
		<th>Property</th>
		<th>Expense</th>
		<th>Amount</th>
		<th></th>
	@endslot
	@foreach ($payments as $payment)
		<tr>
			<td>{{ $payment->statement->property->short_name }}</td>
			<td>{!! $payment->parent->statement_name !!}</td>
			<td>{{ currency($payment->amount) }}</td>
			<td><input type="checkbox" name="payment_id[]" value="{{ $payment->id }}" /></td>
		</tr>
	@endforeach
@endcomponent
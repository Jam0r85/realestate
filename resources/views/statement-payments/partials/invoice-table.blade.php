@component('partials.table')
	@slot('head')
		<th>Inv. Number</th>
		<th>Property</th>
		<th>Amount</th>
		<th></th>
	@endslot
	@foreach ($payments as $payment)
		<tr>
			<td>{{ $payment->parent->number }}</td>
			<td>{{ $payment->statement->property->short_name }}</td>
			<td>{{ currency($payment->amount) }}</td>
			<td><input type="checkbox" name="payment_id[]" value="{{ $payment->id }}" /></td>
		</tr>
	@endforeach
@endcomponent
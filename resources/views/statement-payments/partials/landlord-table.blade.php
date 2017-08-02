@component('partials.table')
	@slot('head')
		<th>Landlord</th>
		<th>Property</th>
		<th>Method</th>
		<th>Amount</th>
		<th></th>
	@endslot
	@foreach ($payments as $payment)
		<tr>
			<td></td>
			<td>{{ $payment->statement->property->short_name }}</td>
			<td>{{ $payment->method_formatted }}</td>
			<td>{{ currency($payment->amount) }}</td>
			<td><input type="checkbox" name="payment_id[]" value="{{ $payment->id }}" /></td>
		</tr>
	@endforeach
@endcomponent
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
			<td></td>
		</tr>
	@endforeach
@endcomponent
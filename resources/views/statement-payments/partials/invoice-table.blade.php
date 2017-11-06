@component('partials.table')
	@slot('header')
		<th>Property</th>
		<th>Number</th>
		<th class="text-right">Amount</th>
		<td></td>
	@endslot
	@slot('body')
		@foreach ($payments as $payment)
			<tr>
				<td>{{ $payment->statement->property->short_name }}</td>
				<td>{{ $payment->parent->number }}</td>
				<td class="text-right">{{ currency($payment->amount) }}</td>
				<td class="text-right">
					@include('statement-payments.partials.payment-checkbox')
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
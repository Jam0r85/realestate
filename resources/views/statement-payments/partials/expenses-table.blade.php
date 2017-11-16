@component('partials.table')
	@slot('header')
		<th>Property</th>
		<th>Expense</th>
		<th class="text-right">Amount</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($payments as $payment)
			<tr>
				<td>{{ $payment->present()->propertyName }}</td>
				<td>{!! $payment->present()->expenseName !!}</td>
				<td class="text-right">{{ currency($payment->amount) }}</td>
				<td class="text-right">
					@include('statement-payments.partials.payment-checkbox')
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
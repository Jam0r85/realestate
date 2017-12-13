@component('partials.table')
	@slot('header')
		<th>Property</th>
		<th>Expense</th>
		<th>Amount</th>
		<th>Method</th>
		<th class="d-print-none"></th>
	@endslot
	@slot('body')
		@foreach ($payments as $payment)
			<tr>
				<td>{{ $payment->present()->propertyName }}</td>
				<td>{!! $payment->present()->expenseName !!}</td>
				<td>{{ currency($payment->amount) }}</td>
				<td>{{ $payment->present()->method }}</td>
				<td class="text-right d-print-none">
					@include('statement-payments.partials.payment-checkbox')
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
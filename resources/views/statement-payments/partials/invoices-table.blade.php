@component('partials.table')
	@slot('header')
		<th>Property</th>
		<th>Number</th>
		<th class="text-right">Amount</th>
		<th class="text-right d-print-none"></th>
		<th class="d-print-none"></th>
	@endslot
	@slot('body')
		@foreach ($payments as $payment)
			<tr>
				<td>{{ $payment->present()->propertyName }}</td>
				<td>{{ $payment->present()->invoiceName }}</td>
				<td class="text-right">{{ currency($payment->amount) }}</td>
				<td class="text-right d-print-none">{!! $payment->present()->recipientBadges !!}</td>
				<td class="text-right d-print-none">
					@include('statement-payments.partials.payment-checkbox')
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
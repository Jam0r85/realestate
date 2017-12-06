@php
	$payments->appends(['section' => 'payments']);
@endphp

<div class="tab-pane fade @if (request('section') == 'payments') show active @endif" id="v-pills-payments" role="tabpanel">

	<a href="{{ route('rent-payments.print', $tenancy->id) }}" class="btn btn-secondary" target="_blank">
		<i class="fa fa-print"></i> Print
	</a>

	<a href="{{ route('rent-payments.print-with-statements', $tenancy->id) }}" class="btn btn-secondary" target="_blank">
		<i class="fa fa-print"></i> Print with Statements
	</a>

	@component('partials.table')
		@slot('header')
			<th>Date</th>
			<th>Amount</th>
			<th>Method</th>
			<th>Note</th>
			<th>Recorded By</th>
			<th>Users</th>
			<th class="text-right"></th>
		@endslot
		@slot('body')
			@foreach ($payments as $payment)
				<tr>
					<td>
						<a href="{{ route('payments.show', $payment->id) }}" title="Payment #{{ $payment->id }}">
							{{ date_formatted($payment->created_at) }}
						</a>
					</td>
					<td>{{ currency($payment->amount) }}</td>
					<td>{{ $payment->method->name }}</td>
					<td>
						<small>{{ $payment->note }}</small>
					</td>
					<td>{{ $payment->owner->present()->fullName }}</td>
					<td>{{ $payment->present()->userNames }}</td>
					<td class="text-right">
						<a href="{{ route('downloads.payment', $payment->id) }}" title="Download" target="_blank" class="btn btn-sm btn-primary">
							Receipt
						</a>
					</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent

	@include('partials.pagination', ['collection' => $payments])
	
</div>
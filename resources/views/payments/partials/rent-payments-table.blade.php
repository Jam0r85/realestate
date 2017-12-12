@component('partials.table')
	@slot('header')
		<th>Date</th>
		@if (!isset($tenancy))
			<th>Tenancy</th>
		@endif
		<th>Amount</th>
		<th>Method</th>
		<th>Users</th>
		<th class="text-right"></th>
	@endslot
	@slot('body')
		@foreach ($payments as $payment)
			<tr>
				<td>{{ date_formatted($payment->created_at) }}</td>
				@if (!isset($tenancy))
					<td>{{ truncate($payment->present()->tenancyName) }}</td>
				@endif
				<td>{{ currency($payment->amount) }}</td>
				<td>{{ $payment->method->name }}</td>
				<td>{!! $payment->present()->userNames !!}</td>
				<td class="text-right">
					<a href="{{ route('payments.show', $payment->id) }}" class="btn btn-primary btn-sm">
						View
					</a>
					<a href="{{ route('downloads.payment', $payment->id) }}" target="_blank" class="btn btn-info btn-sm">
						Receipt
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
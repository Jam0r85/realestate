@component('partials.table')
	@slot('header')
		<th>Date</th>
		<th>Amount</th>
		<th>Method</th>
		<th>For</th>
		<th>Users</th>
		<th class="text-right"></th>
	@endslot
	@slot('body')
		@foreach ($payments as $payment)
			<tr class="clickable-row" data-href="{{ route('payments.show', $payment->id) }}" data-toggle="tooltip" data-placement="left" title="View Payment">
				<td>{{ $payment->present()->dateCreated }}</td>
				<td>{{ $payment->present()->money('amount') }}</td>
				<td>{{ $payment->method->name }}</td>
				<td>{{ truncate($payment->present()->for) }}</td>
				<td>{!! $payment->present()->userBadges !!}</td>
				<td class="text-right">
					<a href="{{ route('downloads.payment', $payment->id) }}" target="_blank" class="btn btn-info btn-sm">
						<i class="fa fa-download"></i>
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
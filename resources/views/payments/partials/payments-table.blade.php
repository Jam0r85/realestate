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
			<tr>
				<td>{{ date_formatted($payment->created_at) }}</td>
				<td>{{ currency($payment->amount) }}</td>
				<td>{{ $payment->method->name }}</td>
				<td>{!! $payment->present()->badge !!} {{ truncate($payment->present()->forName) }}</td>
				<td>{!! $payment->present()->userBadges !!}</td>
				<td class="text-right">
					<a href="{{ route('payments.show', $payment->id) }}" class="btn btn-primary btn-sm">
						View
					</a>
					<a href="{{ route('downloads.payment', $payment->id) }}" target="_blank" class="btn btn-info btn-sm">
						<i class="fa fa-download"></i>
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
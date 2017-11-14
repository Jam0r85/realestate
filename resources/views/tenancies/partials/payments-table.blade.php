@component('partials.table')
	@slot('header')
		<th>Date</th>
		<th>Amount</th>
		<th>Method</th>
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
					@include('partials.bootstrap.users-inline', ['users' => $payment->users])
				</td>
				<td class="text-right">
					<a href="{{ route('downloads.payment', $payment->id) }}" title="Download" target="_blank" class="btn btn-sm btn-primary">
						Receipt
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
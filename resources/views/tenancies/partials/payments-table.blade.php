<table class="table table-striped table-responsive-sm">
	<thead>
		<th>Date</th>
		<th>Amount</th>
		<th>Method</th>
		<th>Users</th>
		<th>Receipt</th>
	</thead>
	<tbody>
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
				<td>
					<a href="{{ route('downloads.payment', $payment->id) }}" title="Download" target="_blank">
						Download
					</a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
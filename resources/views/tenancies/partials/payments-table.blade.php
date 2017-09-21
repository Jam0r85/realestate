<table class="table table-striped table-responsive">
	<thead>
		<th>Date</th>
		<th>Amount</th>
		<th>Method</th>
		<th>Users</th>
		<th>Receipt</th>
	</thead>
	<tbody>
		@foreach ($tenancy->rent_payments()->limit(10)->get() as $payment)
			<tr>
				<td>
					<a href="{{ route('payments.show', $payment->id) }}" title="Payment #{{ $payment->id }}">
						{{ date_formatted($payment->created_at) }}
					</a>
				</td>
				<td>{{ currency($payment->amount) }}</td>
				<td>{{ $payment->method->name }}</td>
				<td>
					@foreach ($payment->users as $user)
						<a href="{{ route('users.show', $user->id) }}" title="{{ $user->name }}" class="badge badge-primary">
							{{ $user->name }}
						</a>
					@endforeach
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

@include('partials.pagination', ['collection' => $tenancies])
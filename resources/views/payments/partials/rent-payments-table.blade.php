<table class="table table-striped table-responsive">
	<thead>
		<th>Date</th>
		<th>Tenancy</th>
		<th>Amount</th>
		<th>Method</th>
		<th>Users</th>
		<th></th>
	</thead>
	<tbody>
		@foreach ($payments as $payment)
			<tr>
				<td>
					<a href="{{ route('payments.show', $payment->id) }}" title="Payment #{{ $payment->id }}">
						{{ date_formatted($payment->created_at) }}
					</a>
				</td>
				<td>
					<a href="{{ route('tenancies.show', $payment->parent_id) }}">
						{!! truncate($payment->parent->name) !!}
					</a>
				</td>
				<td>{{ currency($payment->amount) }}</td>
				<td>{{ $payment->method->name }}</td>
				<td>
					@foreach ($payment->users as $user)
						<a class="badge badge-primary" href="{{ route('users.show', $user->id) }}" title="{{ $user->name }}">
							{{ $user->name }}
						</a>
					@endforeach
				</td>
				<td class="text-right">
					<a href="{{ route('downloads.payment', $payment->id) }}" target="_blank" title="Download">
						<i class="fa fa-pdf"></i> Receipt
					</a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $payments])
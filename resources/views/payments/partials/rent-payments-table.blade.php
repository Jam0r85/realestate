<table class="table table-striped table-hover table-responsive">
	<thead>
		<th>Date</th>
		<th>Tenancy</th>
		<th>Amount</th>
		<th>Method</th>
		<th>Users</th>
		<th class="text-right">
			Receipt
		</th>
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
					@include('partials.bootstrap.users-inline', ['users' => $payment->users])
				</td>
				<td class="text-right">
					<a href="{{ route('downloads.payment', $payment->id) }}" target="_blank" title="Download">
						Download
					</a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $payments])
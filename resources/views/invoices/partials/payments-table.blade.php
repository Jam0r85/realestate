<div class="card mb-3">
	<div class="card-header">
		Invoice Payments
	</div>
	<table class="table table-striped table-responsive">
		<thead>
			<th>Date</th>
			<th>Amount</th>
			<th>Method</th>
			<th>Users</th>
		</thead>
		<tbody>
			@foreach ($invoice->payments as $payment)
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
							<a class="badge badge-primary" href="{{ route('users.show', $user->id) }}" title="{{ $user->name }}">
								{{ $user->name }}
							</a>
						@endforeach
					</td>
				</tr>
			@endforeach
			@foreach ($invoice->statement_payments as $payment)
				<tr>
					<td>
						<a href="{{ route('payments.show', $payment->id) }}" title="Payment #{{ $payment->id }}">
							{{ date_formatted($payment->created_at) }}
						</a>
					</td>
					<td>{{ currency($payment->amount) }}</td>
					<td>
						<a href="{{ route('statements.show', $payment->statement_id) }}">
							Statement #{{ $payment->statement_id }}
						</a>
					</td>
					<td>
						@foreach ($payment->users as $user)
							<a class="badge badge-primary" href="{{ route('users.show', $user->id) }}" title="{{ $user->name }}">
								{{ $user->name }}
							</a>
						@endforeach
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Invoice Payments
	@endcomponent

	<table class="table table-striped table-hover table-responsive">
		<thead>
			<th>Date</th>
			<th>Amount</th>
			<th>Method</th>
			<th>Users</th>
		</thead>
		<tbody>
			
			{{-- Direct invoice payments --}}
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
						@include('partials.bootstrap.users-inline', ['users' => $payment->users])
					</td>
				</tr>
			@endforeach
			{{-- End direct invoice payments --}}

			{{-- Statement invoice payments --}}
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
						@include('partials.bootstrap.users-inline', ['users' => $payment->users])
					</td>
				</tr>
			@endforeach
			{{-- End statement invoice payments --}}

		</tbody>
	</table>
</div>
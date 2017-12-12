@component('partials.table')
	@slot('header')
		<th>Date</th>
		<th>Amount</th>
		<th>Method</th>
		<th>Users</th>
	@endslot
	@slot('body')
		
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
		@foreach ($invoice->statementPayments as $payment)
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

	@endslot
@endcomponent
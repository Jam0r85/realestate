@component('partials.alerts.info')
	Expense payments can created through rental statements for the same property.
@endcomponent

@component('partials.table')
	@slot('header')
		<th>Date</th>
		<th>Statement</th>
		<th>Statement Date</th>
		<th>Tenancy</th>
		<th>Amount</th>
		<th>Status</th>
	@endslot
	@slot('body')
		@foreach ($expense->payments as $payment)
			<tr>
				<td>{{ date_formatted($payment->created_at) }}</td>
				<td>
					<a href="{{ route('statements.show', $payment->statement_id) }}">
						#{{ $payment->statement_id }}
					</a>
				</td>
				<td>{{ date_formatted($payment->statement->period_start) }} - {{ date_formatted($payment->statement->period_end) }}</td>
				<td>{{ $payment->statement->tenancy->present()->name }}</td>
				<td>{{ currency($payment->amount) }}</td>
				<td>{{ $payment->sent_at ? 'Sent' : 'Unsent' }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
@component('partials.table')
	@slot('header')
		<th>Date</th>
		<th>Amount</th>
		<th>Method</th>
		<th>Users</th>
		<th></th>
	@endslot
	@slot('body')
		
		{{-- Direct invoice payments --}}
		@foreach ($invoice->payments as $payment)
			<tr>
				<td>{{ date_formatted($payment->created_at) }}</td>
				<td>{{ currency($payment->amount) }}</td>
				<td>{{ $payment->method->name }}</td>
				<td>{!! $payment->present()->userNames !!}</td>
				<td class="text-right">
					<a href="{{ route('payments.show', $payment->id) }}" class="btn btn-primary btn-sm">
						View
					</a>
				</td>
			</tr>
		@endforeach
		{{-- End direct invoice payments --}}

		{{-- Statement invoice payments --}}
		@foreach ($invoice->statementPayments as $payment)
			<tr>
				<td>{{ date_formatted($payment->created_at) }}</td>
				<td>{{ currency($payment->amount) }}</td>
				<td>
					<a href="{{ route('statements.show', $payment->statement_id) }}">
						Statement #{{ $payment->statement_id }}
					</a>
				</td>
				<td>{!! $payment->present()->recipientNames !!}</td>
				<td class="text-right">
					<a href="{{ route('statement-payments.edit', $payment->id) }}" class="btn btn-primary btn-sm">
						View
					</a>
				</td>
			</tr>
		@endforeach
		{{-- End statement invoice payments --}}

	@endslot
@endcomponent
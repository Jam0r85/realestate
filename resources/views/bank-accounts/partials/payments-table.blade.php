@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Tenancy</th>
		<th>Name</th>
		<th>Amount</th>
		<th></th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($payments as $payment)
			<tr>
				<td>{{ $payment->present()->status }}</td>
				<td>
					<a href="{{ route('tenancies.show', $payment->statement->tenancy->id) }}">
						{{ $payment->present()->tenancyName }}
					</a>
				</td>
				<td>{{ $payment->present()->name }}</td>
				<td>{{ currency($payment->amount) }}</td>
				<td>
					<a href="{{ route('statements.show', $payment->statement->id) }}">
						{{ $payment->present()->statementName }}
					</a>
				</td>
				<td class="text-right">
					<a href="{{ route('statement-payments.edit', $payment->id) }}" class="btn btn-primary btn-sm">
						Edit
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
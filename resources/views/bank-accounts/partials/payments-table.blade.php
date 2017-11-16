@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Tenancy</th>
		<th>Name</th>
		<th>Amount</th>
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
						Statement {{ $payment->statement->id }}
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
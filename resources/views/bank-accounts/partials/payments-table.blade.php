@component('partials.table')
	@slot('header')
		<th>Sent</th>
		<th>Tenancy</th>
		<th>Name</th>
		<th>Amount</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($payments as $payment)
			<tr>
				<td>{{ $payment->sent_at ? date_formatted($payment->sent_at) : 'Not Sent' }}</td>
				<td><a href="{{ route('tenancies.show', $payment->statement->tenancy->id) }}">{{ $payment->statement->tenancy->name }}</a></td>
				<td>{{ $payment->name_formatted }}</td>
				<td>{{ currency($payment->amount) }}</td>
				<td><a href="{{ route('statements.show', $payment->statement->id) }}">Statement</a></td>
			</tr>
		@endforeach
	@endslot
@endcomponent
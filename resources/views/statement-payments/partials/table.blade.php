@component('partials.table')
	@slot('head')
		<th>Statement</th>
		<th>Name</th>
		<th>Method</th>
		<th>Amount</th>
		<th>Sent</th>
	@endslot
	@foreach ($payments as $payment)
		<tr>
			<td><a href="{{ route('statements.show', $payment->statement->id) }}">{{ $payment->statement->name }}</a></td>
			<td>{{ $payment->name_formatted }}</td>
			<td>{{ $payment->method_formatted }}</td>
			<td>{{ currency($payment->amount) }}</td>
			<td>{{ date_formatted($payment->sent_at) }}</td>
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $payments])
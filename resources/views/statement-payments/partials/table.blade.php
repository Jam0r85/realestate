@component('partials.table')
	@slot('head')
		<th>Tenancy</th>
		<th>Statement</th>
		<th>Name</th>
		<th>Method</th>
		<th>Amount</th>
		<th>Sent</th>
		<th>Users</th>
	@endslot
	@foreach ($payments as $payment)
		<tr>
			<td>{{ $payment->statement->tenancy->name }}</td>
			<td>{{ $payment->statement->name }}</td>
			<td>{{ $payment->name_formatted }}</td>
			<td>{{ $payment->method_formatted }}</td>
			<td>{{ currency($payment->amount) }}</td>
			<td>{{ date_formatted($payment->sent_at) }}</td>
			<td></td>
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $payments])
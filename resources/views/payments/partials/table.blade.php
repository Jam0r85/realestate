@component('partials.table')
	@slot('head')
		<th>Tenancy</th>
		<th>Amount</th>
		<th>Method</th>
		<th>When</th>
		<th>Receipt</th>
		<th>Users</th>
	@endslot
	@foreach ($payments as $payment)
		<tr>
			<td>{{ $payment->parent->name }}</td>
			<td>{{ currency($payment->amount) }}</td>
			<td>{{ $payment->method->name }}</td>
			<td>{{ date_formatted($payment->created_at) }}</td>
			<td>View</td>
			<td>
				@foreach ($payment->users as $user)
					<span class="tag is-primary">
						{{ $user->name }}
					</span>
				@endforeach
			</td>
		</tr>
	@endforeach
@endcomponent
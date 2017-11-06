@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Method</th>
		<th>Amount</th>
		<th>Sent</th>
		<th>Users</th>
	@endslot
	@slot('body')
		@foreach ($payments as $payment)
			<tr>
				<td>{{ $payment->name_formatted }}</td>
				<td>@if ($payment->bank_account) Bank @else Cash or Cheque @endif</td>
				<td>{{ currency($payment->amount) }}</td>
				<td>{{ date_formatted($payment->sent_at) }}</td>
				<td>
					@include('partials.bootstrap.users-inline', ['users' => $payment->users])
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent

@include('partials.pagination', ['collection' => $payments])
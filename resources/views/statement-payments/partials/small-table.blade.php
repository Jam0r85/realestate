<table class="table table-striped table-hover table-responsive-sm">
	<thead>
		<th>Name</th>
		<th>Method</th>
		<th>Amount</th>
		<th>Sent</th>
		<th>Users</th>
	</thead>
	<tbody>
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
	</tbody>
</table>

@include('partials.pagination', ['collection' => $payments])
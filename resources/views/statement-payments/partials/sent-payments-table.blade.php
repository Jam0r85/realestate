<table class="table table-striped table-responsive">
	<thead>
		<th>Property</th>
		<th>Statement</th>
		<th>Name</th>
		<th>Method</th>
		<th>Amount</th>
		<th>Sent</th>
	</thead>
	<tbody>
		@foreach ($payments as $payment)
			<tr>
				<td>{!! truncate($payment->statement->tenancy->property->short_name) !!}</td>
				<td>
					<a href="{{ route('statements.show', $payment->statement->id) }}">
						{{ $payment->statement->id}}
					</a>
				</td>
				<td>{{ $payment->name_formatted }}</td>
				<td>{{ $payment->bank_account ? 'Bank' : 'Cash or Cheque' }}</td>
				<td>{{ currency($payment->amount) }}</td>
				<td>{{ date_formatted($payment->sent_at) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $payments])
<table class="table table-striped table-responsive">
	<thead>
		<th>Property</th>
		<th>Start</th>
		<th>End</th>
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
					<a href="{{ route('statements.show', $payment->statement_id) }}">
						{{ date_formatted($payment->statement->period_start) }}
					</a>
				</td>
				<td>{{ date_formatted($payment->statement->period_end) }}</td>
				<td>{{ $payment->name_formatted }}</td>
				<td>@if ($payment->bank_account) Bank @else Cash or Cheque @endif</td>
				<td>{{ currency($payment->amount) }}</td>
				<td>{{ date_formatted($payment->sent_at) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $payments])
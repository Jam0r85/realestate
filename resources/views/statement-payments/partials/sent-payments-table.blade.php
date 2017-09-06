<table class="table table-striped table-responsive">
	<thead>
		<th>Property</th>
		<th>Tenancy</th>
		<th>Name</th>
		<th>Method</th>
		<th>Amount</th>
		<th>Sent</th>
	</thead>
	<tbody>
		@foreach ($sent_payments as $payment)
			<tr>
				<td>{!! truncate($payment->statement->tenancy->property->short_name) !!}</td>
				<td>
					<a href="{{ route('tenancies.show', $payment->statement->tenancy->id) }}">
						{!! truncate($payment->statement->tenancy->name) !!}
					</a>
				</td>
				<td>{{ $payment->name_formatted }}</td>
				<td>@if ($payment->bank_account) Bank @else Cash or Cheque @endif</td>
				<td>{{ currency($payment->amount) }}</td>
				<td>{{ date_formatted($payment->sent_at) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $sent_payments])
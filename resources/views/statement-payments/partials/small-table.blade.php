@component('partials.table')
	@slot('head')
		<th>Name</th>
		<th>Method</th>
		<th>Amount</th>
		<th>Sent</th>
	@endslot
	@foreach ($payments as $payment)
		<tr>
			<td>{{ $payment->name_formatted }}</td>
			<td>@if ($payment->bank_account) Bank @else Cash or Cheque @endif</td>
			<td>{{ currency($payment->amount) }}</td>
			<td>{{ date_formatted($payment->sent_at) }}</td>
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $payments])
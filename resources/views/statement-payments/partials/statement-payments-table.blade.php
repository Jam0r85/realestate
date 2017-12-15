@component('partials.table')
	@slot('header')
		<th>Status</th>
		@if (!isset($statement))
			<th>Property</th>
			<th>Statement</th>
		@endif
		<th>Name</th>
		<th>Method</th>
		<th>Amount</th>
		@if (isset($statement))
			<th>Users</th>
		@endif
		<th></th>
	@endslot
	@slot('body')
		@foreach ($payments as $payment)
			<tr>
				<td>{{ $payment->present()->status }}</td>
				@if (!isset($statement))
					<td>{{ truncate($payment->present()->propertyName) }}</td>
					<td>
						<a href="{{ route('statements.show', $payment->statement->id) }}">
							{{ $payment->present()->statementName }}
						</a>
					</td>
				@endif
				<td>{{ $payment->present()->name }}</td>
				<td>{{ $payment->present()->method }}</td>
				<td>{{ currency($payment->amount) }}</td>
				@if (isset($statement))
					<td>{!! $payment->present()->recipientNames !!}</td>
				@endif
				<td class="text-right">
					<a href="{{ route('statement-payments.edit', $payment->id) }}" class="btn btn-warning btn-sm">
						Edit
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
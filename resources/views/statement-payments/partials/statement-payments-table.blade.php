@component('partials.table')
	@slot('header')
		<th>Status</th>
		@if (!isset($statement))
			<th>Property</th>
		@endif
		<th>Name</th>
		<th>Method</th>
		<th class="text-right">Users</th>
		<th class="text-right">Amount</th>
	@endslot
	@slot('body')
		@foreach ($payments as $payment)
			<tr class="clickable-row" data-href="{{ route('statement-payments.edit', $payment->id) }}" data-toggle="tooltip" data-placement="left" title="Edit this Payment">
				<td>{{ $payment->present()->statusLabel }}</td>
				@if (!isset($statement))
					<td>{{ truncate($payment->present()->propertyName) }}</td>
				@endif
				<td>{{ $payment->present()->name }}</td>
				<td>{{ truncate($payment->present()->method) }}</td>
				<td class="text-right">{!! $payment->present()->userBadges !!}</td>
				<td class="text-right">{{ $payment->present()->money('amount') }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
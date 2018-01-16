@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Number</th>
		<th>Date</th>
		<th>Property</th>
		<th>Total</th>
		<th>Users</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($invoices as $invoice)
			<tr class="clickable-row" data-href="{{ route('invoices.show', $invoice->id) }}">
				<td>{{ $invoice->present()->statusLabel }}</td>
				<td>{{ $invoice->present()->name }}</td>
				<td>{{ $invoice->present()->dateCreated }}</td>
				<td>{{ truncate($invoice->present()->propertyName) }}</td>
				<td>{{ $invoice->present()->money('total') }}</td>
				<td>{!! $invoice->present()->userBadges !!}</td>
				<td class="text-right">
					<a href="{{ route('downloads.invoice', $invoice->id) }}" class="btn btn-info btn-sm" target="_blank">
						@icon('download')
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
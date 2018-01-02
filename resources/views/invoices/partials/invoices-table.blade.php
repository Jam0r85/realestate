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
			<tr>
				<td>{{ $invoice->present()->status }}</td>
				<td>{{ $invoice->name }}</td>
				<td>{{ date_formatted($invoice->created_at) }}</td>
				<td>{{ truncate($invoice->present()->propertyAddress) }}</td>
				<td>{{ currency($invoice->present()->total) }}</td>
				<td>{!! $invoice->present()->userBadges !!}</td>
				<td class="text-right">
					<a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-primary btn-sm">
						@icon('view')
					</a>
					<a href="{{ route('downloads.invoice', $invoice->id) }}" class="btn btn-info btn-sm" target="_blank">
						@icon('download')
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Number</th>
		<th>Date</th>
		<th>Property</th>
		<th>Total</th>
		<th>Users</th>
		<td></td>
	@endslot
	@slot('body')
		@foreach ($invoices as $invoice)
			<tr>
				<td>{{ $invoice->present()->status }}</td>
				<td>
					<a href="{{ route('invoices.show', $invoice->id) }}" title="{{ $invoice->number }}">
						{{ $invoice->name }}
					</a>
				</td>
				<td>{{ date_formatted($invoice->created_at) }}</td>
				<td>{{ $invoice->present()->propertyAddress }}</td>
				<td>{{ currency($invoice->total) }}</td>
				<td>{{ $invoice->present()->usersList }}</td>
				<td class="text-right">
					<a href="{{ route('downloads.invoice', $invoice->id) }}" class="btn btn-primary btn-sm" target="_blank">
						Download
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
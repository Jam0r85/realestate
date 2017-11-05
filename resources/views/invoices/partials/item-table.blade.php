@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Amount</th>
		<th>#</th>
		<th>Tax</th>
		<th class="text-right">Total</th>
	@endslot
	@slot('body')
		@foreach ($items as $invoice_item)
			<tr>
				<td>
					<a href="{{ route('invoices.edit-item', $invoice_item->id) }}" name="Edit Item">
						<b>{{ $invoice_item->name }}</b>
					</a>
					<br /><small>{{ $invoice_item->description }}</small>
				</td>
				<td>{{ currency($invoice_item->amount) }}</td>
				<td>{{ $invoice_item->quantity }}</td>
				<td>{{ $invoice_item->taxRate ? $invoice_item->taxRate->name : null }}</td>
				<td class="text-right">
					{{ currency($invoice_item->total) }}
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent
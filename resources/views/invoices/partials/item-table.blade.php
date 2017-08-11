<table class="table is-striped is-fullwidth">
	<thead>
		<th>Name</th>
		<th>Amount</th>
		<th>Quantity</th>
		<th>Tax</th>
		<th>Total</th>
	</thead>
	<tbody>
		@foreach ($items as $invoice_item)
			<tr>
				<td>
					<a href="#" class="modal-button" data-target="{{ route('invoices.edit-item', $invoice_item->id) }}">
						<b>{{ $invoice_item->name }}</b>
					</a>
					<br />{{ $invoice_item->description }}
				</td>
				<td>{{ currency($invoice_item->amount) }}</td>
				<td>{{ $invoice_item->quantity }}</td>
				<td>{{ $invoice_item->taxRate ? $invoice_item->taxRate->name_formatted : null }}</td>
				<td>{{ currency($invoice_item->total) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
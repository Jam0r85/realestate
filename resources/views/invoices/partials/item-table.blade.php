<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-list"></i> Invoice Items
	</div>
	<table class="table table-striped table-responsive">
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
						<a href="{{ route('invoices.edit-item', $invoice_item->id) }}" name="Edit Item">
							<b>{{ $invoice_item->name }}</b>
						</a>
						<br />{{ $invoice_item->description }}
					</td>
					<td>{{ currency($invoice_item->amount) }}</td>
					<td>{{ $invoice_item->quantity }}</td>
					<td>{{ $invoice_item->taxRate ? $invoice_item->taxRate->name : null }}</td>
					<td>{{ currency($invoice_item->total) }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
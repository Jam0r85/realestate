@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Quantity</th>
		<th class="text-right">Net</th>		
		<th class="text-right">Tax</th>
		<th class="text-right">Total</th>
	@endslot
	@slot('body')
		@foreach ($items as $invoice_item)
			<tr>
				<td>
					<a href="{{ route('invoice-items.edit', $invoice_item->id) }}" name="Edit Item">
						<b>{{ $invoice_item->name }}</b>
					</a><br />
					{{ $invoice_item->description }}
				</td>
				<td>{{ $invoice_item->quantity }}</td>
				<td class="text-right">{{ currency($invoice_item->amount) }}</td>
				<td class="text-right">{{ $invoice_item->taxRate ? $invoice_item->taxRate->name : null }}</td>
				<td class="text-right">
					{{ currency($invoice_item->total) }}
				</td>
			</tr>
		@endforeach
	@endslot
	@slot('footer')
		<tr>
			<td>Totals</td>
			<td></td>
			<td class="text-right">{{ currency($invoice->net) }}</td>			
			<td class="text-right">{{ currency($invoice->tax) }}</td>
			<td class="text-right">{{ currency($invoice->total) }}</td>
		</tr>
	@endslot
@endcomponent
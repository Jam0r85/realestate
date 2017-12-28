@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Quantity</th>
		<th class="text-right">Net</th>		
		<th class="text-right">Tax</th>
		<th class="text-right">Total</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($items as $item)
			<tr>
				<td><b>{{ $item->name }}</b><br />{{ $item->description }}</td>
				<td>{{ $item->quantity }}</td>
				<td class="text-right">{{ currency($item->amount) }}</td>
				<td class="text-right">{{ currency($item->total_tax) }}</td>
				<td class="text-right">
					{{ currency($item->total) }}
				</td>
				<td class="text-right">
					<a href="{{ route('invoice-items.edit', $item->id) }}" class="btn btn-warning btn-sm">
						Edit
					</a>
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
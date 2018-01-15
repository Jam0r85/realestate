@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Quantity</th>
		<th class="text-right">Net</th>		
		<th class="text-right">Tax</th>
		<th class="text-right">Total</th>
	@endslot
	@slot('body')
		@foreach ($items as $item)
			<tr class="clickable-row" data-href="{{ route('invoice-items.edit', $item->id) }}" data-toggle="tooltip" data-placement="left" title="Edit Invoice Item">
				<td><b>{{ $item->name }}</b><br />{{ $item->description }}</td>
				<td>{{ $item->quantity }}</td>
				<td class="text-right">{{ money_formatted($item->amount) }}</td>
				<td class="text-right">{{ money_formatted($item->total_tax) }}</td>
				<td class="text-right">{{ money_formatted($item->total) }}</td>
			</tr>
		@endforeach
	@endslot
	@slot('footer')
		<tr>
			<td>Totals</td>
			<td></td>
			<td class="text-right">{{ money_formatted($invoice->net) }}</td>			
			<td class="text-right">{{ money_formatted($invoice->tax) }}</td>
			<td class="text-right">{{ money_formatted($invoice->total) }}</td>
		</tr>
	@endslot
@endcomponent
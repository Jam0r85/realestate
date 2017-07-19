@extends('invoices.show.layout')

@section('sub-content')

	<h2 class="title is-3">Invoice Items</h2>

	@component('partials.table')
		@slot('head')
			<th>Name</th>
			<th>Amount</th>
			<th>Quantity</th>
			<th>Tax</th>
			<th>Total</th>
		@endslot
		@foreach ($invoice->items as $item)
			<tr>
				<td><a href="#" class="modal-button" data-target="{{ route('invoices.edit-item', [$invoice->id, $item->id]) }}">{{ $item->name }}</a></td>
				<td>{{ currency($item->amount) }}</td>
				<td>{{ $item->quantity }}</td>
				<td>{{ $item->taxRate ? $item->taxRate->name_formatted : null }}</td>
				<td>{{ currency($item->total) }}</td>
			</tr>
		@endforeach
	@endcomponent

@endsection
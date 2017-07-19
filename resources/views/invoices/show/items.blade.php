@extends('invoices.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')
		@slot('title')
			Invoice Items
		@endslot

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
					<td><a href="#" @if (!$invoice->paid_at) class="modal-button" data-target="{{ route('invoices.edit-item', $item->id) }} @endif">{{ $item->name }}</a></td>
					<td>{{ currency($item->amount) }}</td>
					<td>{{ $item->quantity }}</td>
					<td>{{ $item->taxRate ? $item->taxRate->name_formatted : null }}</td>
					<td>{{ currency($item->total) }}</td>
				</tr>
			@endforeach
		@endcomponent

	@endcomponent

	<hr />

	@if ($invoice->paid_at || $invoice->deleted_at)

		<div class="notification is-primary">
			This invoice has been paid or archived. You cannot create new items for it.
		</div>

	@else

		@component('partials.sections.section-no-container')
			@slot('title')
				New Item
			@endslot

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('invoices.create-item', $invoice->id) }}">
				{{ csrf_field() }}

				@include('invoices.partials.item-form')

				<button type="submit" class="button is-primary is-outlined">
					Store Item
				</button>

			</form>

		@endcomponent

	@endif

@endsection
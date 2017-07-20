@extends('invoices.show.layout')

@section('sub-content')

	@component('partials.title')
		Invoice Items
	@endcomponent

	@component('partials.sections.section-no-container')

		@component('partials.subtitle')
			Current Items
		@endcomponent

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

	@component('partials.sections.section-no-container')

		@component('partials.subtitle')
			New Item
		@endcomponent

		@if ($invoice->paid_at || $invoice->deleted_at)

			@component('partials.notifications.primary')
				This invoice has been paid or archived. You cannot create new items for it.
			@endcomponent

		@else

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('invoices.create-item', $invoice->id) }}">
				{{ csrf_field() }}

				@include('invoices.partials.item-form')

				@component('partials.forms.buttons.primary')
					Store Item
				@endcomponent

			</form>

		@endif

	@endcomponent

@endsection
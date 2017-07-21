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
			@foreach ($invoice->items as $invoice_item)
				<tr>
					<td>
						<a href="#" @if (!$invoice->paid_at) class="modal-button" data-target="{{ route('invoices.edit-item', $invoice_item->id) }} @endif">
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
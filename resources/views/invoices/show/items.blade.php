@extends('invoices.show.layout')

@section('sub-content')

	@component('partials.title')
		Invoice Items
	@endcomponent

	@component('partials.sections.section-no-container')

		@component('partials.subtitle')
			Current Items
		@endcomponent

		@include('invoices.partials.item-table', ['items' => $invoice->items])

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
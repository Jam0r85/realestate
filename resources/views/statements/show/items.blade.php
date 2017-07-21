@extends('statements.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Items
		@endcomponent

		@component('partials.subtitle')
			Invoice Items
		@endcomponent

		@include('invoices.partials.item-table', ['items' => $statement->invoice->items])

	@endcomponent

@endsection
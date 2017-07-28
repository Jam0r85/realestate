@extends('statements.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Create Invoice Item
		@endcomponent

		<form role="form" method="POST" action="{{ route('statements.create-invoice-item', $statement->id) }}">
			{{ csrf_field() }}

			@include('partials.errors-block')

			@include('invoices.partials.item-form')

			@component('partials.forms.buttons.primary')
				Create Invoice Item
			@endcomponent
		</form>

	@endcomponent

@endsection
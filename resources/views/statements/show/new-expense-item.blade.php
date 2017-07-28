@extends('statements.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Create Expense Item
		@endcomponent

		<form role="form" method="POST" action="{{ route('statements.create-expense-item', $statement->id) }}">
			{{ csrf_field() }}

			@include('partials.errors-block')

			@include('expenses.partials.form')

			@component('partials.forms.buttons.primary')
				Create Expense Item
			@endcomponent
		</form>

	@endcomponent

@endsection
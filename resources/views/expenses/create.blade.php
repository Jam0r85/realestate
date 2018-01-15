@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Create Expense
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@if (!commonCount('properties'))
			@component('partials.alerts.warning')
				@icon('warning') No properties found, please <a href="{{ route('properties.create') }}">create a property</a> before creating an expense.
			@endcomponent
		@else

			@include('partials.errors-block')

			<form method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
				{{ csrf_field() }}

				@component('partials.card')
					@slot('body')

						@include('expenses.partials.form')

						<div class="form-group">
							<label for="files">Upload Invoice(s)</label>
							<input type="file" id="files" class="form-control-file" name="files[]" multiple />
						</div>

					@endslot
					@slot('footer')
						@component('partials.save-button')
							Create Expense
						@endcomponent
					@endslot
				@endcomponent

			</form>

		@endif

	@endcomponent

@endsection
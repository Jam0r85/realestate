@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Create Property
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('properties.store') }}">
			{{ csrf_field() }}

			@component('partials.card')
				@slot('header')
					Branch
				@endslot
				@slot('body')

					<p class="card-text">
						Please select the branch that you wish to register this property to. Properties can be access by all branches within the system.
					</p>

					@component('partials.form-group')
						<select name="branch_id" id="branch_id" class="form-control" required>
							<option value="">Please select..</option>
							@foreach (common('branches') as $branch)
								<option value="{{ $branch->id }}">
									{{ $branch->name }}
								</option>
							@endforeach
						</select>
					@endcomponent

				@endslot
			@endcomponent

			@component('partials.card')
				@slot('header')
					Details
				@endslot
				@slot('body')

					@include('properties.partials.form')

				@endslot
				@slot('footer')
					@component('partials.save-button')
						Create Property
					@endcomponent
				@endslot
			@endcomponent

		</form>

	@endcomponent

@endsection
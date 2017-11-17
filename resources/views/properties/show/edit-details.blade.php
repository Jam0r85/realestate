@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('properties.show', $property->id) }}" class="btn btn-secondary float-right">
			Return
		</a>

		@component('partials.header')
			{{ $property->present()->shortAddress }}
		@endcomponent

		@component('partials.sub-header')
			Edit Property Details
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Property Details
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('properties.update', $property->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}				

							@include('properties.partials.form')

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

			</div>
		</div>

	@endcomponent

@endsection
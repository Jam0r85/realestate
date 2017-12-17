@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Create Service
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="card mb-3">
			@component('partials.card-header')
				Service Details
			@endcomponent

			<div class="card-body">

				<form role="form" method="POST" action="{{ route('services.store') }}">
					{{ csrf_field() }}

					@include('services.partials.form')

					@component('partials.bootstrap.save-submit-button')
						Create Service
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection
@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				@slot('url')
					{{ route('services.index') }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Edit Service
		@endcomponent

		@component('partials.sub-header')
			Edit Service
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="card mb-3">
			@component('partials.card-header')
				Service Details
			@endcomponent

			<div class="card-body">

				<form method="POST" action="{{ route('services.update', $service->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@include('services.partials.form')

					@component('partials.save-button')
						Update Service
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection
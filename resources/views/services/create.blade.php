@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')
		<div class="page-title">
			<h1>Create Service</h1>
		</div>
	@endcomponent

	@component('partials.bootstrap.section-with-container')

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
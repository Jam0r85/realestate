@extends('layouts.app')

@section('content')

	@component('partials.section-with-container')

		<div class="text-center">
			<h2 class="text-warning mb-5">
				Invalid Permissions
			</h2>

			@component('partials.alerts.warning')
				{{ $exception->getMessage() }}
			@endcomponent

			<a href="{{ url()->previous() }}" class="btn btn-warning">
				@icon('return') Go Back
			</a>
		</div>

	@endcomponent

@endsection
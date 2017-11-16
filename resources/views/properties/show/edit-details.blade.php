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

		<form method="POST" action="{{ route('properties.update', $property->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}				

			@include('properties.partials.form')

			@component('partials.save-button')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

@endsection
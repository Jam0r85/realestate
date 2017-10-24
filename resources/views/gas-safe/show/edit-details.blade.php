@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<a href="{{ route('gas-safe.show', $gas->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				{{ $gas->property->short_name }}
			@endcomponent

			@component('partials.sub-header')
				Edit gas inspection details
			@endcomponent
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('gas-safe.update', $gas->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}			

			@include('gas-safe.partials.form')

			@component('partials.bootstrap.save-submit-button')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

@endsection
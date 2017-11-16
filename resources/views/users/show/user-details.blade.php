@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
			Return
		</a>

		@component('partials.header')
			{{ $user->present()->fullName }}
		@endcomponent

		@component('partials.sub-header')
			Edit Personal Details
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('users.update', $user->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}			

			@include('users.partials.form')

			@component('partials.save-button')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

@endsection
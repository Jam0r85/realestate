@extends('users.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Account
		@endcomponent

		<form role="form" method="POST" action="{{ route('users.update', $user->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			@include('users.partials.form')

			@component('partials.forms.buttons.primary')
				Update
			@endcomponent
		</form>

	@endcomponent

@endsection
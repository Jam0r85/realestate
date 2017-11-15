@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Calendar
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('calendars.store') }}">
			{{ csrf_field() }}

			@include('calendars.partials.form')

			@component('partials.save-button')
				Create Calendar
			@endcomponent

		</form>

	@endcomponent

@endsection
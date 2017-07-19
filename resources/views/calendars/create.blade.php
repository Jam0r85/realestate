@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('calendars.index') }}">Calendars</a></li>
	<li class="is-active"><a>Create New Calendar</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			Create New Calendar
		@endslot
	@endcomponent

	@component('partials.sections.section')

		@include('partials.errors-block')

		<form role="form" method="POST" action="{{ route('calendars.store') }}">
			{{ csrf_field() }}

			@include('calendars.partials.form')

			@component('partials.forms.buttons.save')
				Save Calendar
			@endcomponent

		</form>

	@endcomponent

@endsection
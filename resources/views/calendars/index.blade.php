@extends('layouts.app')

@section('breadcrumbs')
	<li class="is-active"><a>Calendars</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			Calendars
		@endslot
	@endcomponent

	@component('partials.sections.section')

		@include('calendars.partials.table', ['calendars' => $calendars])

	@endcomponent

@endsection
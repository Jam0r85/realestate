@extends('layouts.pages.calendar')

@section('sub-content')

	@component('partials.sections.section')

		@include('events.partials.table', ['events' => $calendar->archivedEvents()])

	@endcomponent

@endsection
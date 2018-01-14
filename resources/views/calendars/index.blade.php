@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('calendars.create') }}" class="btn btn-primary float-right" title="New Calendar">
			<i class="fa fa-plus"></i> New Calendar
		</a>

		@component('partials.header')
			Calendars List
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@component('partials.table')
			@slot('header')
				<th>Name</th>
				<th>Branch</th>
				<th>Events</th>
				<th>Archived Events</th>
			@endslot
			@slot('body')
				@foreach ($calendars as $calendar)
					<tr class="clickable-row" data-href="{{ route('calendars.show', $calendar->id) }}">
						<td>{{ $calendar->name }}</td>
						<td>{{ $calendar->branch->name }}</td>
						<td>{{ $calendar->events->count() }}</td>
						<td>{{ $calendar->archivedEvents->count() }}</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

	@endcomponent

@endsection
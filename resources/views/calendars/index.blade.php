@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('calendars.create') }}" class="btn btn-primary float-right" title="New Calendar">
			<i class="fa fa-user-plus"></i> New Calendar
		</a>

		@component('partials.header')
			Calendars List
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@component('partials.table')
			@slot('header')
				<th>Name</th>
				<th>Events</th>
				<th>Archived Events</th>
				<th>Access</th>
			@endslot
			@slot('body')
				@foreach ($calendars as $calendar)
					<tr>
						<td>
							<a href="{{ route('calendars.show', $calendar->id) }}" title="{{ $calendar->name }}">
								{{ $calendar->name }}
							</a>
						</td>
						<td>{{ $calendar->events->count() }}</td>
						<td>{{ $calendar->archivedEvents->count() }}</td>
						<td></td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

	@endcomponent

@endsection
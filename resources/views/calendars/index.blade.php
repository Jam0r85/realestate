@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('calendars.create') }}" class="btn btn-primary float-right" title="New Calendar">
				<i class="fa fa-user-plus"></i> New Calendar
			</a>

			@component('partials.header')
				Calendars List
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<table class="table table-striped table-hover table-responsive">
			<thead>
				<th>Name</th>
				<th>Events</th>
				<th>Archived Events</th>
				<th>Access</th>
			</thead>
			<tbody>
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
			</tbody>
		</table>

	@endcomponent

@endsection
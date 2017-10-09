@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')
		<div class="page-title">
			<h1>
				{{ $title }}
			</h1>
		</div>
	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<table class="table table-striped table-hover table-responsive">
			<thead>
				<th>Date</th>
				<th>Time</th>
				<th>Title</th>
				<th>Calendar</th>
				<th>Creator</th>
			</thead>
			<tbody>
				@foreach ($events as $event)
					<tr>
						<td>{{ date_formatted($event->start) }}</td>
						<td>{{ time_formatted($event->start) }}</td>
						<td>
							@if ($event->trashed())
								<span class="text-muted float-right">
									<i class="fa fa-archive"></i> Archived
								</span>
							@endif
							<a href="{{ route('events.edit', $event->id) }}" title="{{ $event->title }}">
								{{ $event->title }}
							</a>
						</td>
						<td>{{ $event->calendar->name }}</td>
						<td>{{ $event->owner->name }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		@include('partials.pagination', ['collection' => $events])

	@endcomponent

@endsection
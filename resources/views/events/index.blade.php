@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			{{ $title }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		{{-- Events Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('events.search') }}
			@endslot
			@if (session('events_search_term'))
				@slot('search_term')
					{{ session('events_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Events Search --}}

		@component('partials.table')
			@slot('header')
				<th>Date</th>
				<th>Time</th>
				<th>Title</th>
				<th>Calendar</th>
				<th class="text-right">Creator</th>
			@endslot
			@slot('body')
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
						<td class="text-right">
							<a href="{{ route('users.show', $event->owner->id) }}" title="{{ $event->owner->name }}">
								{{ $event->owner->name }}
							</a>
						</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

		@include('partials.pagination', ['collection' => $events])

	@endcomponent

@endsection
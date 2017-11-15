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

		@foreach ($events as $event)

			<div class="card mb-3">

				@component('partials.card-header')
					{{ $event->title }}
				@endcomponent

				<div class="card-body">
					<p class="card-text">
						<small class="text-muted">by {{ $event->owner->name }} for {{ datetime_formatted($event->start) }}</small>
					</p>

					<p class="card-text">
						{{ $event->body }}
					</p>
				</div>

			</div>

		@endforeach

		@include('partials.pagination', ['collection' => $events])

	@endcomponent

@endsection
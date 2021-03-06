@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			{{ $title }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.index-search', ['route' => 'events.search', 'session' => 'event_search_term'])

		<ul class="nav nav-pills">
			{!! (new Filter())->monthDropdown() !!}
			{!! (new Filter())->yearDropdown('App\Event') !!}
			{!! Filter::archivePill() !!}

			{!! Filter::clearButton() !!}
		</ul>

		<div class="row equal-height">

			@foreach ($events as $event)

				<div class="col-12 col-md-6 col-lg-4">

					<div class="card mb-4 @if ($event->trashed()) border-warning @endif">

						@component('partials.card-header')
							{{ $event->title }}
						@endcomponent

						<div class="card-body">
							<p class="card-text">
								<small class="text-muted">by {{ $event->owner->present()->fullName }} for {{ datetime_formatted($event->start) }}</small>
							</p>

							<p class="card-text">
								{{ $event->body }}
							</p>

							<p class="card-text text-right">
								<a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary">
									<i class="fa fa-edit"></i> Edit
								</a>
							</p>
						</div>

					</div>

				</div>

			@endforeach

		</div>

		@include('partials.pagination', ['collection' => $events])

	@endcomponent

@endsection
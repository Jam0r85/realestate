@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')
		<div class="page-title">
			<h1>
				Edit Event - {{ $event->title }}
			</h1>
		</div>
	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<form role="form" method="POST" action="{{ route('events.update', $event->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" name="title" class="form-control" required value="{{ $event->title }}" />
			</div>

			<div class="form-group">
				<label for="body">Message</label>
				<textarea name="body" class="form-control" rows="6">{{ $event->body }}</textarea>
			</div>

			<div class="form-group">
				<label for="title">Start Date</label>
				<input type="datetime-local" name="start" class="form-control" required value="{{ $event->start->format('Y-m-d\TH:i:s') }}" />
			</div>

			<div class="form-group">
				<label for="title">End Date</label>
				<input type="datetime-local" name="end" class="form-control" required value="{{ $event->end->format('Y-m-d\TH:i:s') }}" />
			</div>

			@if ($event->trashed())
		
				<div class="card border-info mb-3">
					<div class="card-body">
						<h5 class="card-title">
							Restore Event
						</h5>
						<p class="card-text">
							You can restore this event by entering the word 'restore' in the field below.
						</p>

						<input type="text" name="restore_event" class="form-control" />

					</div>
				</div>

			@else

				<div class="card border-danger mb-3">
					<div class="card-body">
						<h5 class="card-title">
							Delete Event
						</h5>
						<p class="card-text">
							You can delete this event by entering the word 'delete' in the field below.
						</p>

						<input type="text" name="delete_event" class="form-control" />

					</div>
				</div>

			@endif

			@component('partials.bootstrap.save-submit-button')
				Update Event
			@endcomponent

		</form>

	@endcomponent

@endsection
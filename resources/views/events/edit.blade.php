@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('events.index') }}" class="btn btn-secondary float-right">
			Return
		</a>

		@component('partials.header')
			Event #{{ $event->id }}
		@endcomponent

		@component('partials.sub-header')
			Edit Event Details
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block') 

		<div class="row">
			<div class="col-sm-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Event Details
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('events.update', $event->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="created_by">Created By</label>
								<input type="text" name="created_by" id="created_by" class="form-control" value="{{ $event->owner->present()->fullName }}" disabled />
							</div>

							<div class="form-group">
								<label for="title">Title</label>
								<input type="text" name="title" id="title" class="form-control" required value="{{ $event->title }}" />
							</div>

							<div class="form-group">
								<label for="body">Message</label>
								<textarea name="body" id="body" class="form-control" rows="12">{{ $event->body }}</textarea>
							</div>

							<div class="form-group">
								<label for="title">Start Date &amp; Time</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="datetime-local" name="start" id="start" class="form-control" required value="{{ $event->start->format('Y-m-d\TH:i:s') }}" />
								</div>
							</div>

							<div class="form-group">
								<label for="title">End Date &amp; Time</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="datetime-local" name="end" id="end" class="form-control" required value="{{ $event->end->format('Y-m-d\TH:i:s') }}" />
								</div>
							</div>

							@component('partials.save-button')
								Update Event
							@endcomponent

						</form>

					</div>
				</div>

			</div>
			<div class="col-sm-12 col-lg-6">

				@if ($event->trashed())

					<form method="POST" action="{{ route('events.restore', $event->id) }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
			
						<div class="card mb-3">

							@component('partials.card-header')
								Restore Event
							@endcomponent

							<div class="card-body">

								<p class="card-text">
									You can restore this event by entering the event ID into the field below.
								</p>

								<div class="form-group">
									<input type="text" name="confirmation" class="form-control" />
								</div>

								@component('partials.save-button')
									Restore Event
								@endcomponent

							</div>
						</div>

					</form>

					<form method="POST" action="{{ route('events.force-destroy', $event->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
			
						<div class="card mb-3">

							@component('partials.card-header')
								Force Delete Event
							@endcomponent

							<div class="card-body">

								@if (Auth::user()->id == $event->owner->id)

									<p class="card-text">
										To confirm that you want to force delete this event and remove it from the database totally, please enter the ID of this event into the field below.
									</p>

									<div class="form-group">
										<input type="text" name="confirmation" class="form-control" />
									</div>

									@component('partials.save-button')
										Force Delete
									@endcomponent

								@else

									<p class="card-text text-danger">
										Only the owner of an event can force delete it and remove it completely.
									</p>

								@endif

							</div>
						</div>

					</form>

				@else

					<form method="POST" action="{{ route('events.destroy', $event->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						<div class="card mb-3">

							@component('partials.card-header')
								Delete Event
							@endcomponent

							<div class="card-body">

								<p class="card-text">
									To confirm that you want to delete this event, please enter the ID number of the event into the field below.
								</p>

								<p class"card-text">
									This will perform a 'soft delete' and the event will still be kept in the database but instead be hidden in the calendar.
								</p>

								<div class="form-group">
									<input type="number" step="any" name="confirmation" id="confirmation" class="form-control" />
								</div>

								@component('partials.save-button')
									Delete Event
								@endcomponent

							</div>
						</div>

					</form>

				@endif

			</div>
		</div>

	@endcomponent

@endsection
@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				{{ $user->name }}
			@endcomponent

			@component('partials.sub-header')
				Update Settings
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('users.update-settings', $user->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="card mb-3">

				@component('partials.bootstrap.card-header')
					Site Settings
				@endcomponent

				<div class="card-body">

					<div class="form-group">
						<label for="calendar_event_color">Calendar Event Colour</label>
						<input type="text" name="calendar_event_color" class="form-control" value="{{ array_has($user->settings, 'calendar_event_color') ? $user->settings['calendar_event_color'] : '' }}" />
						<small class="form-text text-muted">
							Choose the colour for events created by this user.
						</small>
					</div>

					<div class="form-group">
						<label for="font_override">Font Override Family</label>
						<input type="text" name="font_override" class="form-control" value="{{ array_has($user->settings, 'font_override') ? $user->settings['font_override'] : '' }}" />
						<small class="form-text text-muted">
							Override the font for this site. Note that the font you enter must be installed onto the system you are using for it to work.
						</small>
					</div>

					<div class="form-group">
						<label for="font_override_size">Font Override Size</label>
						<input type="text" name="font_override_size" id="font_override_size" class="form-control" value="{{ array_has($user->settings, 'font_override_size') ? $user->settings['font_override_size'] : '' }}" />
					</div>

				</div>
			</div>

			@component('partials.save-button')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

@endsection
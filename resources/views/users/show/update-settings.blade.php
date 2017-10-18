@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
				Return
			</a>
			<h1>{{ $user->name }}</h1>
			<h3 class="text-muted">Update Settings</h3>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form role="form" method="POST" action="{{ route('users.update-settings', $user->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="form-group">
				<label for="calendar_event_color">Calendar Event Colour</label>
				<select name="calendar_event_color" id="calendar_event_color" class="form-control">
					<option value="">Default</option>
					<option @if ($user->settings['calendar_event_color'] == "red") selected @endif value="red">Red</option>
					<option value="orange">Orange</option>
					<option value="blue">Blue</option>
				</select>
				<small class="form-text text-muted">
					Choose the colour for events created by this user.
				</small>
			</div>

			@component('partials.bootstrap.save-submit-button')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

@endsection
@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
			Return
		</a>

		@component('partials.header')
			{{ $user->name }}
		@endcomponent

		@component('partials.sub-header')
			Send an E-Mail
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@if (!$user->email)

			@component('partials.alerts.danger')
				This user does not have a valid e-mail address.
			@endcomponent

		@else

			<form method="POST" action="{{ route('users.send-email', $user->id) }}">
				{{ csrf_field() }}

				@include('partials.errors-block')

				<div class="form-group">
					<label for="email">E-Mail</label>
					<input type="text" name="email" id="email" class="form-control" disabled value="{{ $user->email }}" />
				</div>	

				<div class="form-group">
					<label for="subject">Subject</label>
					<input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" />
					<small class="form-text text-muted">
						The subject of the e-mail and the e-mail header.
					</small>
				</div>	

				<div class="form-group">
					<label for="message">Message</label>
					<textarea name="message" id="message" rows="12" class="form-control">{{ old('message') }}</textarea>
				</div>

				@component('partials.save-button')
					Send E-Mail
				@endcomponent

			</form>

		@endif

	@endcomponent

@endsection
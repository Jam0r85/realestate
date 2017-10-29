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
				Change user password
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<form method="POST" action="{{ route('users.update-password', $user->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="form-group">
				<label for="password">New Password</label>
				<input type="password" class="form-control" name="password" id="password" />
			</div>

			<div class="form-group">
				<label for="password_confirmation">Confirm New Password</label>
				<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" />
			</div>

			<div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" name="notify_user" value="true" checked >
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Notify this user that their password has changed?</span>
				</label>
			</div>

			<div class="form-group">
				<label for="notify_message">Message to User (optional)</label>
				<textarea name="notify_message" id="notify_message" class="form-control" rows="8"></textarea>
				<small class="form-text text-muted">
					Send the user a custom message letting them know why their password was changed.
				</small>
			</div>

			@component('partials.save-button')
				Change Password
			@endcomponent

		</form>

	@endcomponent

@endsection
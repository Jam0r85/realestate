@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				@slot('url')
					{{ route('users.show', $user->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $user->present()->fullName }}
		@endcomponent

		@component('partials.sub-header')
			Change user password
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="card mb-3">

			@component('partials.card-header')
				Change Password
			@endcomponent

			<div class="card-body">

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

					<div class="form-check">
						<label class="form-check-label">
							<input type="checkbox" class="form-check-input" name="notify_user" value="true" checked >
							Notify the user that their password has been changed?
						</label>
					</div>

					<div class="form-group">
						<label for="notify_message">Message to User (optional)</label>
						<textarea name="notify_message" id="notify_message" class="form-control" rows="4"></textarea>
						<small class="form-text text-muted">
							Send the user a custom message letting them know why their password was changed.
						</small>
					</div>

					@component('partials.save-button')
						Change Password
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection
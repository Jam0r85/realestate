@extends('users.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Change Password
		@endcomponent

		<form role="form" method="POST" action="{{ route('users.update-password', $user->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="field">
				<label class="label" for="password">New Password</label>
				<p class="control">
					<input type="password" class="input" name="password" />
				</p>
			</div>

			<div class="field">
				<label class="label" for="password_confirmation">Confirm New Password</label>
				<p class="control">
					<input type="password" class="input" name="password_confirmation" />
				</p>
			</div>

			@component('partials.forms.buttons.primary')
				Update Password
			@endcomponent

		</form>

	@endcomponent

@endsection
@extends('users.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Account
		@endcomponent

		@component('partials.subtitle')
			Update Account Details
		@endcomponent

		<form role="form" method="POST" action="{{ route('users.update', $user->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			@include('users.partials.form')

			@component('partials.forms.buttons.primary')
				Update
			@endcomponent
		</form>

	@endcomponent

	<hr />

	@component('partials.sections.section-no-container')

		@component('partials.subtitle')
			Update E-Mail
		@endcomponent

		<form role="form" method="POST" action="{{ route('users.update-email', $user->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="field">
				<label class="label" for="email">New E-Mail</label>
				<p class="control">
					<input type="email" name="email" class="input" value="{{ old('email') }}" />
				</p>
			</div>

			<div class="field">
				<label class="label" for="email_confirmation">Confirm New E-Mail</label>
				<p class="control">
					<input type="email" name="email_confirmation" class="input" value="" />
				</p>
			</div>

			@component('partials.forms.buttons.primary')
				Update E-Mail
			@endcomponent
		</form>

	@endcomponent

	<hr />

	@component('partials.sections.section-no-container')

		@component('partials.subtitle')
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
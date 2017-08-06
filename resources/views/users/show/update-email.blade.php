@extends('users.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
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

@endsection
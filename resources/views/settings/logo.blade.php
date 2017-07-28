@extends('settings.template')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Settings
		@endcomponent

		@component('partials.subtitle')
			Company Logo
		@endcomponent

		@if (get_setting('company_logo'))

			<img src="{{ get_file(get_setting('company_logo')) }}" />

			<form role="form" method="POST" action="{{ route('settings.remove-logo') }}">
				{{ csrf_field() }}

				@component('partials.forms.buttons.primary')
					Remove Logo
				@endcomponent

			</form>

			<hr />

		@else

			@component('partials.notifications.primary')
				No logo has been uploaded.
			@endcomponent

		@endif

		<form role="form" method="POST" action="{{ route('settings.update-logo') }}" enctype="multipart/form-data">
			{{ csrf_field() }}

			<div class="field">
				<label class="label" for="company_logo">
					Upload New Logo
				</label>
				<p class="control">
					<input type="file" name="company_logo" class="input">
				</p>
			</div>

			@component('partials.forms.buttons.primary')
				Update
			@endcomponent

		</form>

	@endcomponent

@endsection
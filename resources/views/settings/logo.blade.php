@extends('settings.template')

@section('sub-content')

	<form role="form" method="POST" action="{{ route('settings.update-logo') }}" enctype="multipart/form-data">
		{{ csrf_field() }}

		@component('partials.sections.section-no-container')

			@component('partials.title')
				Settings
			@endcomponent

			@component('partials.subtitle')
				Company Logo
			@endcomponent

			@if (get_setting('company_logo'))

				<img src="{{ get_file(get_setting('company_logo')) }}" />

			@else

				@component('partials.notifications.primary')
					No logo has been uploaded.
				@endcomponent

			@endif

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

		@endcomponent

	</form>

@endsection
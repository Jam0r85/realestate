@extends('settings.template')

@section('sub-content')

	<form role="form" method="POST" action="{{ route('settings.update') }}">
		{{ csrf_field() }}

		@component('partials.sections.section-no-container')

			@component('partials.title')
				Settings
			@endcomponent

			@component('partials.subtitle')
				Company Settings
			@endcomponent

			<div class="field">
				<label class="label" for="company_name">
					Company Name
				</label>
				<p class="control">
					<input type="text" name="company_name" class="input" value="{{ get_setting('company_name') }}" />
				</p>
			</div>

			<div class="field">
				<label class="label" for="invoice_default_terms">
					Default Invoice Terms
				</label>
				<p class="control">
					<textarea name="invoice_default_terms" class="textarea">{{ get_setting('invoice_default_terms') }}</textarea>
				</p>
			</div>

			@component('partials.forms.buttons.primary')
				Update
			@endcomponent

		@endcomponent

	</form>

@endsection
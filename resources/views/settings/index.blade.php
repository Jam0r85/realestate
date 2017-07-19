@extends('settings.template')

@section('sub-content')

	<form role="form" method="POST" action="{{ route('settings.update') }}">
		{{ csrf_field() }}

		@component('partials.sections.section-no-container')
			@slot('title')
				General Settings
			@endslot
			@slot('saveButton')
				Save Changes
			@endslot

			@component('partials.forms.field')
				@slot('label')
					Company Name
				@endslot
				@slot('name')
					company_name
				@endslot
				@slot('value')
					{{ getSetting('company_name') }}
				@endslot
			@endcomponent

			@component('partials.forms.field-select')
				@slot('label')
					Default Country
				@endslot

				<span class="select">
					<select name="default_country">

					</select>
				</span>

			@endcomponent

		@endcomponent

	</form>

@endsection
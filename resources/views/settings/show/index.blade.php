<form method="POST" action="{{ route('settings.update') }}">
	{{ csrf_field() }}
	{{ method_field('PUT') }}

	@component('partials.card')
		@slot('header')
			Application Settings
		@endslot

		@slot('body')

			@component('partials.form-group')
				@slot('label')
					Default Country
				@endslot
				@slot('help')
					Set the default country to the country this business is based in. This will effect new properties and the currency used.
				@endslot

				<select name="default_country" id="default_country" class="form-control select2">
					@foreach (Countries::all()->pluck('name.common')->sortBy('name.common') as $country)
						<option @if (get_setting('default_country') == $country) selected @endif>
							{{ $country }}
						</option>
					@endforeach
				</select>
			@endcomponent

		@endslot

		@slot('footer')
			@component('partials.save-button')
				Save
			@endcomponent
		@endslot
	@endcomponent

</form>

<form method="POST" action="{{ route('settings.update') }}">
	{{ csrf_field() }}
	{{ method_field('PUT') }}

	@component('partials.card')
		@slot('header')
			Date Settings
		@endslot

		@slot('body')

			@component('partials.form-group')
				@slot('label')
					Date Format
				@endslot

				<input type="text" name="date_format" id="date_format" value="{{ get_setting('date_format') }}" />

			@endcomponent

			@component('partials.form-group')
				@slot('label')
					Date Time Format
				@endslot

				<input type="text" name="date_time_format" id="date_time_format" value="{{ get_setting('date_time_format') }}" />

			@endcomponent

		@endslot

		@slot('footer')
			@component('partials.save-button')
				Save
			@endcomponent
		@endslot
	@endcomponent

</form>
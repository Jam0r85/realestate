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
					@foreach (countries() as $country)
						<option @if (get_setting('default_country') == $country['common']) selected @endif>
							{{ $country['common'] }}
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
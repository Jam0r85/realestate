<div class="field">

	{{-- Label --}}
	@if (isset($label))
		<label class="label" @if (isset($name)) for="{{ $name }}" @endif >{{ $label }}</label>
	@endif

	{{-- Control Class for the Field --}}
	<p class="control">
		@component('partials.forms.textarea')

			{{-- Field Name --}}
			@if (isset($name))
				@slot('name')
					{{ $name }}
				@endslot
			@endif

			{{-- Field Value --}}
			@if (isset($value))
				@slot('value')
					{{ $value }}
				@endslot
			@endif

			{{-- Field Placehlder --}}
			@if (isset($placeholder))
				@slot('placeholder')
					{{ $placeholder }}
				@endslot
			@endif

		@endcomponent

	</p>
	
	{{-- Help --}}
	@if (isset($help))
		<p class="help">{{ $help }}</p>
	@endif
</div>
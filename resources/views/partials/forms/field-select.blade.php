<div class="field">

	{{-- Label --}}
	@if (isset($label))
		<label class="label" @if (isset($name)) for="{{ $name }}" @endif >{{ $label }}</label>
	@endif

	{{-- Control Class for the Field --}}
	<p class="control">
		{{ $slot }}
	</p>

	{{-- Help --}}
	@if (isset($help))
		<p class="help">{{ $help }}</p>
	@endif
</div>
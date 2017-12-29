<div class="form-group">

	@if (isset($label))
		<label for="{{ $label }}">{{ $label }}</label>
	@endif

	{{ $slot }}

	@if (isset($help))
		<small class="form-text text-muted">
			{{ $help }}
		</small>
	@endif
	
</div>
<div class="form-group">
	<label>{{ $label }}</label>

	{{ $slot }}

	@if (isset($help))
		<small class="form-text text-muted">
			{{ $help }}
		</small>
	@endif
</div>
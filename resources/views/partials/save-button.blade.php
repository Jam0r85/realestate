<button type="submit" class="btn btn-primary" {{ isset($disabled) ? 'disabled' : '' }}>
	@icon('save') {{ $slot }}
</button>
<li class="list-group-item {{ isset($style) ? $style : '' }} flex-column">
	<div class="d-flex justify-content-between">
		@if (isset($title))
			<span class="{{ !isset($style) ? 'text-muted' : '' }}">
				{{ $title }}
			</span>
		@endif
		<span class="text-right">
			{{ $slot }}
		</span>
	</div>

	@if (isset($extra))
		<div class="mt-2">
			{{ $extra }}
		</div>
	@endif
</li>
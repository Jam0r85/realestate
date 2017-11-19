<div class="card-header {{ isset($style) ? $style : '' }} {{ user_setting('dark_mode') ? 'bg-dark' : '' }}">
	<span class="{{ !user_setting('dark_mode') ? 'text-primary' : '' }}">
		{{ $slot }}
	</span>

	@if (isset($small))
		<small class="text-muted d-block">
			{{ $small }}
		</small>
	@endif

</div>
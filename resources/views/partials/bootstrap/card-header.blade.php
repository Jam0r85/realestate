<div class="card-header {{ isset($style) ? $style : '' }} {{ user_setting('dark_mode') ? 'bg-dark' : '' }}">
	{{ $slot }}

	@if (isset($small))
		<small class="text-muted d-block">
			{{ $small }}
		</small>
	@endif

</div>
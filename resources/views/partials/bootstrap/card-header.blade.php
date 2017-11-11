<h5 class="card-header {{ isset($style) ? $style : '' }} {{ user_setting('dark_mode') ? 'bg-dark' : 'text-primary' }}">
	{{ $slot }}

	@if (isset($small))
		<small class="text-muted d-block">
			{{ $small }}
		</small>
	@endif

</h5>
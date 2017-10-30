<div class="card-header {{ isset($style) ? $style : '' }}">
	{{ $slot }}

	@if (isset($small))
		<small class="text-muted d-block">
			{{ $small }}
		</small>
	@endif

</div>
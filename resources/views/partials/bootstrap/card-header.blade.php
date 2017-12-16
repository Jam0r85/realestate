<div class="card-header">
	{{ $slot }}

	@if (isset($small))
		<small class="text-muted d-block">
			{{ $small }}
		</small>
	@endif

</div>
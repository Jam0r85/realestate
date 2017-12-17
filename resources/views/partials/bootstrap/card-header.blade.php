<div class="card-header">
	<span class="text-primary">
		{{ $slot }}
	</span>

	@if (isset($small))
		<small class="text-muted d-block">
			{{ $small }}
		</small>
	@endif

</div>
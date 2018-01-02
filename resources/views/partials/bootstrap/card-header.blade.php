<h5 class="card-header">
	<span class="text-primary">
		{{ $slot }}
	</span>

	@if (isset($small))
		<small class="text-muted d-block">
			{{ $small }}
		</small>
	@endif

</h5>
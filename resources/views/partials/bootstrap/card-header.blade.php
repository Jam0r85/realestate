<div class="card-header">
	<span>
		{{ $slot }}
	</span>

	@if (isset($small))
		<small class="text-muted d-block">
			{{ $small }}
		</small>
	@endif

</div>
<li class="list-group-item flex-column">
	<div class="d-flex justify-content-between">
		@if (isset($title))
			<span class="text-muted">
				{{ $title }}
			</span>
		@endif
		{{ $slot }}
	</div>
</li>
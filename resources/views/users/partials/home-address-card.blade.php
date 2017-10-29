<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Current Location
		<small class="d-block text-muted">
			Where the user currently lives.
		</small>
	@endcomponent

	<div class="card-body">

		@if ($user->currentLocation())
			<a href="{{ route('properties.show', $user->currentLocation()->id) }}">
				{{ $user->currentLocation()->name }}
			</a>
		@endif

	</div>
</div>
<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		<small class="text-muted float-right">
			Where the user currently lives.
		</small>
		Current Location
	@endcomponent

	<div class="card-body">

		@if ($user->currentLocation())
			<a href="{{ route('properties.show', $user->currentLocation()->id) }}">
				{{ $user->currentLocation()->name }}
			</a>
		@endif

	</div>
</div>
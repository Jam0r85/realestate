<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Current Location
	@endcomponent

	<div class="card-body">

		{{ $user->currentLocation() }}

	</div>
</div>
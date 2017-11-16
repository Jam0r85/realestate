<div class="card mb-3">

	@component('partials.card-header')
		Current Location
		<small class="d-block text-muted">
			Where the user currently lives.
		</small>
	@endcomponent

	<div class="card-body">

		{{ $user->present()->location('full') }}

	</div>
</div>
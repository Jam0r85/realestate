<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		<small class="text-muted float-right">
			Users who own this property
		</small>
		Owners
	@endcomponent

	@include('partials.bootstrap.users-list-group', ['users' => $property->owners])

</div>

<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		<small class="text-muted float-right">
			Users living at property
		</small>
		Residents
	@endcomponent

	@include('partials.bootstrap.users-list-group', ['users' => $property->currentResidents()])

</div>
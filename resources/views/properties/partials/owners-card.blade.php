<div class="card mb-3">

	@component('partials.card-header')
		Owners
		@slot('small')
			Users who own this property
		@endslot
	@endcomponent

	@include('partials.bootstrap.users-list-group', ['users' => $property->owners])

</div>

<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Residents
		@slot('small')
			Users living at property
		@endslot
	@endcomponent

	@include('partials.bootstrap.users-list-group', ['users' => $property->currentResidents()])

</div>
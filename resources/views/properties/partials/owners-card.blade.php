<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Owners
	@endcomponent

	@include('partials.bootstrap.users-list-group', ['users' => $property->owners])

</div>
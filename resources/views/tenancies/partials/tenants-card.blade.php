<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Tenants
	@endcomponent

	@if (!count($tenancy->tenants))

		<div class="card-body">
			<p class="card-text">
				No users have been added as tenants to this tenancy.
			</p>
		</div>

	@else

		@include('partials.bootstrap.users-list-group', ['users' => $tenancy->tenants])

	@endif

</div>
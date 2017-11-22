<div class="tab-pane fade @if (request('section') == 'details' || (!request('section') && $loop->first)) show active @endif" id="v-pills-details" role="tabpanel">

	<div class="row">
		<div class="col-sm-12">

			<div class="row mb-3">
				<div class="col">

					@include('tenancies.partials.tenancy-rent-card')

				</div>
				<div class="col">

					@include('tenancies.partials.tenancy-deposit-card')

				</div>
			</div>

		</div>
	</div>

	<div class="card mb-3">
		@component('partials.card-header')
			Tenants
		@endcomponent
		@include('users.partials.users-table', ['users' => $tenancy->tenants])
	</div>

	<div class="row">
		<div class="col-12 col-lg-6">
			@include('tenancies.partials.tenancy-details-card')
		</div>
		<div class="col-12 col-lg-6">
			@include('tenancies.partials.service-card')
		</div>
	</div>
	
	@include('tenancies.partials.system-info-card')

</div>
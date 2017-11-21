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

	@include('tenancies.partials.tenants-card')
	@include('tenancies.partials.system-info-card')
	@include('tenancies.partials.tenancy-details-card')
	@include('tenancies.partials.service-card')
	@include('tenancies.partials.agreement-card')

</div>
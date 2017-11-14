@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@include('tenancies.partials.dropdown-menus')
		</div>

		@component('partials.header')
			{{ $tenancy->name }}
		@endcomponent

		@component('partials.sub-header')
			{{ $tenancy->property->name }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@if ($tenancy->trashed())
			<div class="alert alert-secondary">
				This tenancy was <b>archived</b> on {{ date_formatted($tenancy->deleted_at) }}
			</div>
		@endif

		@if ($tenancy->vacated_on && $tenancy->vacated_on > \Carbon\Carbon::now())
			<div class="alert alert-danger">
				The tenants are <b>vacating</b> this property on {{ date_formatted($tenancy->vacated_on) }}
			</div>
		@endif

		@if ($tenancy->vacated_on && $tenancy->vacated_on <= \Carbon\Carbon::now())
			<div class="alert alert-danger">
				The tenants <b>vacated</b> this property on {{ date_formatted($tenancy->vacated_on) }}
			</div>
		@endif

		<div class="row">
			<div class="col-sm-12">

				<div class="row mb-3">
					<div class="col">

						<div class="card text-white text-center bg-primary">
							<div class="card-body">
								<h4 class="card-title">
									{{ currency($tenancy->getRentBalance()) }}
								</h4>
								<p class="card-text">
									Rent Balance
								</p>
							</div>
						</div>

					</div>
					<div class="col">

						<div class="card text-white text-center bg-primary">
							<div class="card-body">
								<h4 class="card-title">
									{{ currency($tenancy->deposit ? $tenancy->deposit->amount : 0) }}
								</h4>
								<p class="card-text">
									Deposit Balance
								</p>
							</div>
						</div>

					</div>
				</div>

			</div>
			<div class="col-sm-12 col-lg-3">

				@include('tenancies.partials.tenants-card')
				@include('tenancies.partials.system-info-card')

			</div>
			<div class="col-sm-12 col-lg-3">

				@include('tenancies.partials.tenancy-details-card')
				@include('tenancies.partials.service-card')
				@include('tenancies.partials.agreement-card')

			</div>
			<div class="col-sm-12 col-lg-6">

				<div role="tablist">
					<div class="card">

						@component('partials.card-header')

							<a data-toggle="collapse" href="#latestRentPaymentsCollapse">
								Latest Rent Payments
							</a>

						@endcomponent

						<div id="latestRentPaymentsCollapse" class="collapse show">

							@include('tenancies.partials.payments-table', ['payments' => $tenancy->rent_payments()->limit(5)->get()])

						</div>

						@component('partials.card-header')

							<a data-toggle="collapse" href="#latestStatementsCollapse">
								Latest Statements
							</a>

						@endcomponent

						<div id="latestStatementsCollapse" class="collapse show">

							@include('tenancies.partials.statements-table', ['statements' => $tenancy->statements()->limit(5)->get()])

						</div>

					</div>
				</div>

			</div>
		</div>

	@endcomponent

	@include('tenancies.modals.tenancy-rent-payment-modal')
	@include('tenancies.modals.tenancy-statement-modal')

@endsection
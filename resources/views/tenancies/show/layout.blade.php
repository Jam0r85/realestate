@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@include('tenancies.partials.dropdown-menus')
		</div>

		@component('partials.header')
			{{ $tenancy->name }}
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
			<div class="col-sm-12 col-lg-3">

				@include('tenancies.partials.tenants-card')
				@include('tenancies.partials.tabs')
				@include('tenancies.partials.system-info-card')

			</div>
			<div class="col-sm-12 col-lg-3">

				@include('tenancies.partials.tenancy-details-card')

				<div class="row">
					<div class="col">
						@include('tenancies.partials.rent-info-card')
					</div>
					<div class="col">
						@include('tenancies.partials.deposit-info-card')
					</div>
				</div>

				@include('tenancies.partials.service-card')
				@include('tenancies.partials.agreement-card')

			</div>
			<div class="col-sm-12 col-lg-6">

				<div role="tablist">
					<div class="card">

						<div class="card-header" role="tab" id="latestRentPayments">
							<span class="float-right">
								{{ currency($tenancy->getRentBalance()) }}
								<small class="text-muted">Balance</small>
							</span>
							<h5 class="mb-0">
								<a data-toggle="collapse" href="#latestRentPaymentsCollapse">
									Latest Rent Payments
								</a>
							</h5>
						</div>

						<div id="latestRentPaymentsCollapse" class="collapse show">

							@include('tenancies.partials.payments-table', ['payments' => $tenancy->rent_payments()->limit(10)->get()])

						</div>

						<div class="card-header" role="tab" id="latestStatements">
							<h5 class="mb-0">
								<a data-toggle="collapse" href="#latestStatementsCollapse">
									Latest Statements
								</a>
							</h5>
						</div>

						<div id="latestStatementsCollapse" class="collapse show">

							@include('tenancies.partials.statements-table', ['statements' => $tenancy->statements()->limit(10)->get()])

						</div>

					</div>
				</div>

			</div>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<ul class="nav nav-tabs" id="userTabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#payments" role="tab">Payments</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#statements" role="tab">Statements</a>
			</li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane fade show active" id="payments" role="tabpanel">
				
				@include('tenancies.partials.payments-table', ['payments' => $tenancy->rent_payments()->limit(10)->get()])

				<a href="{{ route('tenancies.show', [$tenancy->id, 'rent-payments-received']) }}" title="View All Rent Payments Received" class="btn btn-primary">
					View All Rent Payments
				</a>

			</div>
			<div class="tab-pane fade" id="statements" role="tabpanel">

				@include('tenancies.partials.statements-table')

				<a href="{{ route('tenancies.show', [$tenancy->id, 'statements']) }}" title="View All Statements" class="btn btn-primary">
					View All Statements
				</a>

			</div>
		</div>

	@endcomponent

@endsection
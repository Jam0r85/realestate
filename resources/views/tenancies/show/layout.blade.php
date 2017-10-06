@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<div class="float-right">
					@include('tenancies.partials.dropdown-menus')
				</div>
				<h1>{{ $tenancy->name }}</h1>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

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
				<div class="col col-5">

					@include('tenancies.partials.tenants-card')
					@include('tenancies.partials.tabs')
					@include('tenancies.partials.system-info-card')

				</div>
				<div class="col">

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
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

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

		</div>
	</section>

@endsection
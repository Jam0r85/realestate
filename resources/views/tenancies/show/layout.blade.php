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

			<div class="row">
				<div class="col col-5">

					@include('tenancies.partials.tenants-card')
					@include('tenancies.partials.tabs')
					@include('tenancies.partials.system-info-card')

				</div>
				<div class="col col-7">

					@include('tenancies.partials.rent-info-card')
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
				<div class="tab-pane active" id="payments" role="tabpanel">
					
					@include('tenancies.partials.payments-table')

					<a href="{{ route('tenancies.show', [$tenancy->id, 'rent-payments-received']) }}" title="View All Rent Payments Received" class="btn btn-primary">
						View All Rent Payments Received
					</a>

				</div>
				<div class="tab-pane" id="statements" role="tabpanel">

					@include('tenancies.partials.statements-table')

				</div>
			</div>

		</div>
	</section>

@endsection
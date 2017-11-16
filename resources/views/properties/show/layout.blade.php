@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@include('properties.partials.dropdown-menus')
		</div>

		@component('partials.header')
			{{ $property->present()->shortAddress }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@if ($property->trashed())

			@component('partials.alerts.secondary')
				This property was <b>archived</b> on {{ date_formatted($property->deleted_at) }}
			@endcomponent

		@endif

		<div class="row">
			<div class="col-sm-12 col-lg-5">

				@include('properties.partials.owners-card')
				@include('properties.partials.gas-reminder-card')
				@include('properties.partials.system-info-card')

			</div>
			<div class="col-sm-12 col-lg-7">

				@include('properties.partials.property-info-card')

			</div>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="card mb-3">
			<div class="card-body">

				<ul class="nav nav-pills nav-justified" id="userTabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#tenancies" role="tab">Tenancies</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#invoices" role="tab">Invoices</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#statements" role="tab">Statements</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#expenses" role="tab">Expenses</a>
					</li>
				</ul>

			</div>

			<div class="tab-content">
				<div class="tab-pane active" id="tenancies" role="tabpanel">

					@include('tenancies.partials.tenancies-table', ['tenancies' => $property->tenancies])

				</div>
				<div class="tab-pane" id="invoices" role="tabpanel">

					@include('invoices.partials.invoices-table', ['invoices' => $property->invoices()->limit(10)->get()])

				</div>
				<div class="tab-pane" id="statements" role="tabpanel">

					

				</div>
				<div class="tab-pane" id="expenses" role="tabpanel">

				</div>
			</div>

		</div>
		
	@endcomponent

@endsection
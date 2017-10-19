@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<div class="float-right">
				@include('properties.partials.dropdown-menus')
			</div>
			<h1>{{ $property->short_name }}</h1>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@if ($property->trashed())

			<div class="alert alert-secondary">
				This property was <b>archived</b> on {{ date_formatted($property->deleted_at) }}
			</div>

		@endif

		<div class="row">
			<div class="col col-5">

				@include('properties.partials.owners-card')
				@include('properties.partials.gas-reminder-card')
				@include('properties.partials.system-info-card')

			</div>
			<div class="col col-7">

				@include('properties.partials.property-info-card')

			</div>
		</div>

		<hr />

		<ul class="nav nav-tabs" id="userTabs" role="tablist">
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

		<div class="tab-content">
			<div class="tab-pane active" id="tenancies" role="tabpanel">

				@include('properties.partials.tenancies-table')

			</div>
			<div class="tab-pane" id="invoices" role="tabpanel">

				@include('properties.partials.invoices-table')

			</div>
			<div class="tab-pane" id="statements" role="tabpanel">

				@include('properties.partials.statements-table')

			</div>
			<div class="tab-pane" id="expenses" role="tabpanel">

			</div>
		</div>
		
	@endcomponent

@endsection
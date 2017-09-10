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

@endsection
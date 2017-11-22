@php
	$sections = [
		'Details' => 'details',
		'Payments' => 'rent_payments',
		'Statements' => 'statements',
		'Agreements' => 'agreements',
		'Rent Amounts' => 'rents'
	];
@endphp

@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@include('tenancies.partials.dropdown-menus')
		</div>

		@component('partials.header')
			{{ $tenancy->present()->name }}
		@endcomponent

		@component('partials.sub-header')
			{{ $tenancy->present()->propertyAddress('full') }}
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
			<div class="col-12 col-md-4 col-lg-3 col-xl-2">

				<div class="nav flex-column nav-pills mb-5" id="v-pills-tab" role="tablist" aria-orientation="vertical">

					@foreach ($sections as $key => $value)
						<a class="nav-link @if (request('section') == str_slug($key)) active @elseif (!request('section') && $loop->first) active @endif" id="v-pills-{{ str_slug($key) }}-tab" data-toggle="pill" href="#v-pills-{{ str_slug($key) }}" role="tab">
							{{ $key }}
							@if (method_exists($tenancy, $value))
								<span class="badge badge-light">
									{{ count($tenancy->$value) }}
								</span>
							@endif
						</a>
					@endforeach

					<div class="dropdown-divider"></div>

					<a class="nav-link @if (request('section') == 'deposit') active @endif" id="v-pills-deposit-tab" data-toggle="pill" href="#v-pills-deposit" role="tab">
						Deposit
						@if ($tenancy->deposit)
							<span class="badge badge-success">
								<i class="fa fa-check"></i>
							</span>
						@endif
					</a>

				</div>

			</div>
			<div class="col-12 col-md-8 col-lg-9 col-xl-10">

				<div class="tab-content" id="v-pills-tabContent">

					@foreach ($sections as $key => $value)
						@include('tenancies.sections.' . str_slug($key))
					@endforeach

					@include('tenancies.sections.deposit')

				</div>

			</div>
		</div>

	@endcomponent

	@include('tenancies.modals.tenancy-rent-payment-modal')
	@include('tenancies.modals.tenancy-statement-modal')
	@include('tenancies.modals.new-rent-amount-modal')

@endsection
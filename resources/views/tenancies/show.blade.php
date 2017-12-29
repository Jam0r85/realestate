@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="mb-3 text-right">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tenancyRentPaymentModal">
				<i class="fa fa-plus"></i> Payment
			</button>

			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#newStatementModal">
				<i class="fa fa-plus"></i> Statement
			</button>

			<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#newRentAmount">
				<i class="fa fa-plus"></i> Rent
			</button>

			<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#newTenancyAgreement">
				<i class="fa fa-plus"></i> Agreement
			</button>

			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="tenanciesOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-cogs"></i> Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="tenanciesOptionsDropdown">
					<a class="dropdown-item" href="{{ route('tenancies.edit', $tenancy->id) }}" title="Edit Tenancy">
						<i class="fa fa-edit"></i> Edit Tenancy
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			{{ $tenancy->present()->name }}
		@endcomponent

		@component('partials.sub-header')
			{{ $tenancy->property->present()->fullAddress }}
		@endcomponent
		
	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		@if ($tenancy->vacated_on && $tenancy->vacated_on <= \Carbon\Carbon::now())
			@component('partials.alerts.warning')
				@component('partials.icon')
					@lang('icons.calendar')
				@endcomponent
				Tenancy ending on {{ date_formatted($tenancy->vacated_on) }}
			@endcomponent
		@endif

		@if ($tenancy->vacated_on && $tenancy->vacated_on > \Carbon\Carbon::now())
			@component('partials.icon')
				@lang('icons.calendar')
			@endcomponent
			@component('partials.alerts.warning')
				Tenancy ended on {{ date_formatted($tenancy->vacated_on) }}
			@endcomponent
		@endif

		<ul class="nav nav-pills">
			<li class="nav-item">
				{!! Menu::showLink('Details', 'tenancies.show', $tenancy->id, 'index') !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Payments', 'tenancies.show', $tenancy->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Statements', 'tenancies.show', $tenancy->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Agreements', 'tenancies.show', $tenancy->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Rents', 'tenancies.show', $tenancy->id) !!}
			</li>
		</ul>

		@include('tenancies.show.' . $show)

	@endcomponent

	@include('tenancies.modals.tenancy-rent-payment-modal')
	@include('statements.modals.new-statement-modal')
	@include('tenancies.modals.new-rent-amount-modal')

@endsection
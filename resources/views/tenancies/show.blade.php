@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="mb-3 text-right">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tenancyRentPaymentModal">
				@icon('plus') Payment
			</button>

			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#newStatementModal">
				@icon('plus') Statement
			</button>

			<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#newRentAmount">
				@icon('plus') Rent
			</button>

			<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#newAgreementModal">
				@icon('plus') Agreement
			</button>

			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="tenanciesOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					@icon('cogs') Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="tenanciesOptionsDropdown">
					<a class="dropdown-item" href="{{ route('tenancies.edit', $tenancy->id) }}" title="Edit Tenancy">
						@icon('edit') Edit Tenancy
					</a>
					<a class="dropdown-item" href="{{ route('old-statements.create', $tenancy->id) }}">
						@icon('statement') Record Old Statement
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

		@include('tenancies.partials.quick-alerts')

		<ul class="nav nav-pills">
			<li class="nav-item">
				<a class="nav-link @if (!Request::segment(3)) active @endif" href="{{ route('tenancies.show', $tenancy->id) }}">
					Details
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (Request::segment(3) == 'payments') active @endif" href="{{ route('tenancies.show', [$tenancy->id, 'payments']) }}">
					Payments
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (Request::segment(3) == 'statements') active @endif" href="{{ route('tenancies.show', [$tenancy->id, 'statements']) }}">
					Statements
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (Request::segment(3) == 'agreements') active @endif" href="{{ route('tenancies.show', [$tenancy->id, 'agreements']) }}">
					Agreements
				</a>
			</li>
				<a class="nav-link @if (Request::segment(3) == 'rents') active @endif" href="{{ route('tenancies.show', [$tenancy->id, 'rents']) }}">
					Rents
				</a>
			</li>
		</ul>

		@include('tenancies.show.' . $show)

	@endcomponent

	@include('tenancies.modals.tenancy-rent-payment-modal')
	@include('statements.modals.new-statement-modal')
	@include('tenancies.modals.new-rent-amount-modal')
	@include('agreements.modals.new-agreement-modal')

@endsection
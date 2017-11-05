@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<div class="float-right">
				@include('invoices.partials.dropdown-menu')
			</div>

			@component('partials.header')
				Invoice {{ $invoice->name }}
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@if ($invoice->trashed())

			@component('partials.alerts.secondary')
				This invoice was <b>archived</b> on {{ date_formatted($invoice->deleted_at) }}
			@endcomponent

		@endif

		@if ($invoice->isPaid())

			@component('partials.alerts.success')
				Invoice {{ $invoice->name }} was <b>Paid</b> on {{ date_formatted($invoice->paid_at) }}
			@endcomponent

		@endif

		<div class="row">
			<div class="col col-4">

				@include('invoices.partials.linked-users-card')
				@include('invoices.partials.statement-card')
				@include('invoices.partials.balance-card')
				@include('invoices.partials.system-info-card')

			</div>
			<div class="col">

				@include('invoices.partials.invoice-details-card')

				<div class="card mb-3">

					@component('partials.card-header')
						Invoice Items
					@endcomponent

					@include('invoices.partials.item-table', ['items' => $invoice->items])

				</div>

				<div class="card mb-3">

					@component('partials.card-header')
						Invoice Payments
					@endcomponent

					@include('invoices.partials.payments-table')

				</div>

			</div>
		</div>

	@endcomponent

@endsection
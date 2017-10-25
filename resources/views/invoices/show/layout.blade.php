@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<div class="float-right">
					@include('invoices.partials.dropdown-menu')
				</div>
				<h1>Invoice {{ $invoice->name }}</h1>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			@if ($invoice->trashed())

				@component('partials.alerts.secondary')
					This invoice was <b>archived</b> on {{ date_formatted($invoice->deleted_at) }}
				@endcomponent

			@endif

			@if ($invoice->paid_at)

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
					@include('invoices.partials.item-table', ['items' => $invoice->items])
					@include('invoices.partials.payments-table')

				</div>
			</div>

		</div>
	</section>

@endsection
@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<div class="float-right">
					@include('invoices.partials.dropdown-menu')
				</div>
				<h1>Invoice #{{ $invoice->number }}</h1>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

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
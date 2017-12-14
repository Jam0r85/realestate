@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@include('expenses.partials.dropdown-menus')
		</div>

		@component('partials.header')
			{{ $expense->name }}
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')	

		@includeIf($expense->isPaid(), 'partials.alerts.success', ['slot' => 'This expense was paid ' . date_formatted($expense->paid_at)])

		<div class="row">
			<div class="col col-5">

				@include('expenses.partials.invoices-card')
				@include('expenses.partials.system-info-card')

			</div>
			<div class="col col-7">

				@include('expenses.partials.expense-info-card')

			</div>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<ul class="nav nav-tabs" id="userTabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#payments" role="tab">Payments</a>
			</li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane active" id="payments" role="tabpanel">

				@include('expenses.partials.payments-table')

			</div>
		</div>

	@endcomponent

@endsection
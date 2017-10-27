@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<div class="float-right">
					@include('expenses.partials.dropdown-menus')
				</div>
				<h1>{{ $expense->name }}</h1>
			</div>

			@if ($expense->paid_at)
				<div class="alert alert-success">
					This expense was paid {{ date_formatted($expense->paid_at) }}
				</div>
			@endif

			<div class="row">
				<div class="col col-5">

					@include('expenses.partials.invoices-card')
					@include('expenses.partials.system-info-card')

				</div>
				<div class="col col-7">

					@include('expenses.partials.expense-info-card')

				</div>
			</div>

			<hr />

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

		</div>
	</section>

@endsection
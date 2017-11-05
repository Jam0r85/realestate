@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<div class="float-right">
				@include('users.partials.user-dropdown-menu')
			</div>

			@component('partials.header')
				{{ $user->name }}
			@endcomponent

		</div>
		
	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col col-5">

				@include('users.partials.home-address-card')
				@include('users.partials.system-info-card')

			</div>
			<div class="col col-7">

				@include('users.partials.user-info-card')

			</div>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="card">
			<div class="card-body">

				<ul class="nav nav-pills nav-justified" id="userTabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#properties" role="tab">Properties</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#tenancies" role="tab">Tenancies</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#invoices" role="tab">Invoices</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#expenses" role="tab">Expenses</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#bank_accounts" role="tab">Bank Accounts</a>
					</li>
				</ul>

			</div>

			<div class="tab-content">
				<div class="tab-pane active" id="properties" role="tabpanel">

					@include('properties.partials.properties-table', ['properties' => $user->properties])

				</div>
				<div class="tab-pane" id="tenancies" role="tabpanel">

					@include('tenancies.partials.tenancies-table', ['tenancies' => $user->tenancies])

				</div>
				<div class="tab-pane" id="invoices" role="tabpanel">

					@include('invoices.partials.invoices-table', ['invoices' => $user->invoices()->limit(10)->get()])

				</div>
				<div class="tab-pane" id="expenses" role="tabpanel">

					@include('expenses.partials.expenses-table', ['expenses' => $user->expenses()->limit(10)->get()])

				</div>
				<div class="tab-pane" id="bank_accounts" role="tabpanel">

					@include('bank-accounts.partials.bank-accounts-table', ['accounts' => $user->bankAccounts])

				</div>
			</div>

		</div>

	@endcomponent

@endsection
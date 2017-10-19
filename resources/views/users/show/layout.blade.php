@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')
		<div class="page-title">
			<div class="float-right">
				@include('users.partials.dropdown-menus')
			</div>
			<h1>{{ $user->name }}</h1>
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

	</div>
</section>

<section class="section">
	<div class="container">

		<ul class="nav nav-tabs" id="userTabs" role="tablist">
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

		<div class="tab-content">
			<div class="tab-pane active" id="properties" role="tabpanel">

				<table class="table table-striped table-responsive">
					<thead>
						<th>Name</th>
					</thead>
					<tbody>
						@foreach ($user->properties as $property)
							<tr>
								<td><a href="{{ route('properties.show', $property->id) }}">{{ $property->name }}</a></td>
							</tr>
						@endforeach
					</tbody>
				</table>

			</div>
			<div class="tab-pane" id="tenancies" role="tabpanel">

				@include('users.partials.tenancies-table')

			</div>
			<div class="tab-pane" id="invoices" role="tabpanel">

				@include('users.partials.invoices-table')

			</div>
			<div class="tab-pane" id="expenses" role="tabpanel">

				@include('users.partials.expenses-table')

			</div>
			<div class="tab-pane" id="bank_accounts" role="tabpanel">

				<table class="table table-striped table-hover table-responsive">
					<thead>
						<th>Bank</th>
						<th>Account Name</th>
						<th>Sort Code</th>
						<th>Account Number</th>
						<th></th>
					</thead>
					<tbody>
						@foreach ($user->bankAccounts as $account)
							<tr>
								<td>{{ $account->bank_name }}</td>
								<td>{{ $account->account_name }}</td>
								<td>{{ $account->sort_code }}</td>
								<td>{{ $account->account_number }}</td>
								<td class="text-right">
									<a href="{{ route('bank-accounts.show', $account->id) }}">
										Edit
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

			</div>
		</div>

	@endcomponent

@endsection
@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@include('bank-accounts.partials.dropdown-menus')
		</div>

		@component('partials.header')
			{{ $account->account_name }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col-sm-12 col-lg-5">


				@include('bank-accounts.partials.system-info-card')

			</div>
			<div class="col-sm-12 col-lg-7">

				@include('bank-accounts.partials.account-info-card')

			</div>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="card">

			<div class="card-body">

				<ul class="nav nav-pills nav-justified" id="bankAccountTabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#properties" role="tab">Properties</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#payments" role="tab">Payments</a>
					</li>
				</ul>

			</div>

			<div class="tab-content">
				<div class="tab-pane active" id="properties" role="tabpanel">

					@include('properties.partials.properties-table', ['properties' => $account->properties])

				</div>
				<div class="tab-pane" id="payments" role="tabpanel">

					@include('bank-accounts.partials.payments-table')

				</div>
			</div>

		</div>

	@endcomponent

@endsection
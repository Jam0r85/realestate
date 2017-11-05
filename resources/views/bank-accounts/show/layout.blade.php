@extends('layouts.app')

@section('content')

	@component('prtials.bootstrap.section-with-container')

		<div class="page-title">

			<div class="float-right">
				@include('bank-accounts.partials.dropdown-menus')
			</div>

			@component('partials.header')
				{{ $account->account_name }}
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstap.section-with-container')

		<div class="row">
			<div class="col col-5">

				@include('bank-accounts.partials.linked-users-card')
				@include('bank-accounts.partials.system-info-card')

			</div>
			<div class="col col-7">

				@include('bank-accounts.partials.account-info-card')

			</div>
		</div>

	@endcomponent

	@component('partials.bootstap.section-with-container')

		<div class="card">

			<div class="card-body">

				<ul class="nav nav-pills nav-justify" id="bankAccountTabs" role="tablist">
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

					@include('bank-accounts.partials.properties-table')

				</div>
				<div class="tab-pane" id="payments" role="tabpanel">

					@include('bank-accounts.partials.payments-table')

				</div>
			</div>

		</div>

	@endcomponent

@endsection
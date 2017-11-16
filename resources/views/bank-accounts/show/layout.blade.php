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
			<div class="col-12 col-lg-5">

				@include('bank-accounts.partials.account-info-card')
				@include('bank-accounts.partials.system-info-card')				

			</div>
			<div class="col-12 col-lg-7">

				<div role="tablist">
					<div class="card">

						@component('partials.card-header')

							<a data-toggle="collapse" href="#linkedPropertiesCollapse">
								Linked Properties
							</a>

						@endcomponent

						<div id="linkedPropertiesCollapse" class="collapse show">

							@include('properties.partials.properties-table', ['properties' => $account->properties()->with('owners')->get()])

						</div>

						@component('partials.card-header')

							<a data-toggle="collapse" href="#linkedPaymentsCollapse">
								Linked Payments
							</a>

						@endcomponent

						<div id="linkedPaymentsCollapse" class="collapse">

							@include('bank-accounts.partials.payments-table', ['payments' => $account->statement_payments()->with('statement','statement.tenancy','statement.tenancy.tenants')->limit(10)->get()])

						</div>

					</div>
				</div>

			</div>
		</div>

	@endcomponent

@endsection
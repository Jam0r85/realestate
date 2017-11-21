@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@include('users.partials.user-dropdown-menu')
		</div>

		@component('partials.header')
			{{ $user->present()->fullName }}
		@endcomponent
		
	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col-12 col-lg-3">

				@include('users.partials.home-address-card')
				@include('users.partials.system-info-card')

			</div>
			<div class="col-12 col-lg-4">

				@include('users.partials.user-info-card')

			</div>
			<div class="col-12 col-lg-5">

				<div role="tablist">
					<div class="card">

						@component('partials.card-header')

							<a data-toggle="collapse" href="#propertiesCollapse">
								Linked Properties
							</a>

						@endcomponent

						<div id="propertiesCollapse" class="collapse show">

							

						</div>

						@component('partials.card-header')

							<a data-toggle="collapse" href="#tenanciesCollapse">
								Linked Tenancies
							</a>

						@endcomponent

						<div id="tenanciesCollapse" class="collapse show">


						</div>

						@component('partials.card-header')

							<a data-toggle="collapse" href="#latestInvoicesCollapse">
								Linked Invoices
							</a>

						@endcomponent

						<div id="latestInvoicesCollapse" class="collapse">


						</div>

						@component('partials.card-header')

							<a data-toggle="collapse" href="#bankAccountsCollapse">
								Linked Bank Accounts
							</a>

						@endcomponent

						<div id="bankAccountsCollapse" class="collapse">


						</div>

					</div>
				</div>

			</div>
		</div>

	@endcomponent

	@include('users.modals.user-send-sms-modal')

@endsection
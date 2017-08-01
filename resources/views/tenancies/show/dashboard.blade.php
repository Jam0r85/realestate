@extends('tenancies.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@include('partials.errors-block')

		<div class="tile is-ancestor">
			<div class="tile is-6">
				<div class="tile is-vertical is-parent">

					<div class="tile is-child card">
						<header class="card-header">
							<p class="card-header-title">
								Record Rent Payment
							</p>
						</header>
						<div class="card-content">

							@if ($tenancy->canRecordRentPayment())

								<form role="form" method="POST" action="{{ route('tenancies.create-rent-payment', $tenancy->id) }}">
									{{ csrf_field() }}

									@include('tenancies.partials.payment-form')

									@component('partials.forms.buttons.primary')
										Record Payment
									@endcomponent

								</form>

							@else
								<p>This tenancy cannot accept new rent payments.</p>
							@endif

						</div>
					</div>

				</div>
			</div>
			<div class="tile is-6">
				<div class="tile is-vertical is-parent">

					<div class="tile is-child card">
						<header class="card-header">
							<p class="card-header-title">
								Create Rental Statement
							</p>
						</header>
						<div class="card-content">

							<form role="form" method="POST" action="{{ route('tenancies.create-rental-statement', $tenancy->id) }}">
								{{ csrf_field() }}

								@include('tenancies.partials.statement-form')

								@component('partials.forms.buttons.primary')
									Create Statement
								@endcomponent

							</form>

						</div>
					</div>

				</div>
			</div>
		</div>

	@endcomponent

@endsection
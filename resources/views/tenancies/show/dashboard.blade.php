@extends('tenancies.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		<div class="columns">
			<div class="column">

				<div class="field is-grouped is-grouped-multiline">
					<div class="control">
						<div class="tags has-addons">
							<span class="tag is-medium is-dark">Started</span>
							<span class="tag is-medium is-primary">{{ date_formatted($tenancy->created_at) }}</span>
						</div>
					</div>
					@if ($tenancy->vacated_on)
						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-medium is-dark">Vacated</span>
								<span class="tag is-medium is-primary">{{ date_formatted($tenancy->vacated_on) }}</span>
							</div>
						</div>
					@endif
					<div class="control">
						<div class="tags has-addons">
							<span class="tag is-medium is-dark">Latest Rent Payment</span>
							<span class="tag is-medium is-primary">{{ $tenancy->last_rent_payment ? date_formatted($tenancy->last_rent_payment->created_at) : 'Never' }}</span>
						</div>
					</div>
					<div class="control">
						<div class="tags has-addons">
							<span class="tag is-medium is-dark">Next Statement Due</span>
							<span class="tag is-medium is-primary">{{ date_formatted($tenancy->next_statement_start_date) }}</span>
						</div>
					</div>
				</div>

			</div>
		</div>

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

							@if ($tenancy->canCreateStatement())

								<form role="form" method="POST" action="{{ route('tenancies.create-rental-statement', $tenancy->id) }}">
									{{ csrf_field() }}

									@include('tenancies.partials.statement-form')

									@component('partials.forms.buttons.primary')
										Create Statement
									@endcomponent

								</form>

							@else
								<p>This tenancy cannot accept new rental statements.</p>
							@endif

						</div>
					</div>

				</div>
			</div>
		</div>

	@endcomponent

@endsection
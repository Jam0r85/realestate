@extends('tenancies.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		<div class="columns">
			<div class="column is-6">

				<div class="card">
					<header class="card-header">
						<p class="card-header-title">
							Record Rent Payment
						</p>
					</header>
					<div class="card-content">

						<form role="form" method="POST" action="{{ route('tenancies.create-rent-payment', $tenancy->id) }}">
							{{ csrf_field() }}

							@include('tenancies.partials.payment-form')

							@component('partials.forms.buttons.primary')
								Record Payment
							@endcomponent

						</form>

					</div>
				</div>

			</div>
		</div>

	@endcomponent

@endsection
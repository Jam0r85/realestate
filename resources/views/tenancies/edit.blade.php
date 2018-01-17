@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('tenancies.show', $tenancy->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $tenancy->present()->name }}
		@endcomponent

		@component('partials.sub-header')
			Edit Tenancy
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('tenancies.update', $tenancy->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Tenancy Details
						@endslot
						@slot('body')

							@component('partials.form-group')
								@slot('label')
									Date Started
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" name="started_on" id="started_on" class="form-control" value="{{ $tenancy->present()->dateInput('started_on', old('started_on')) }}" />
								@endcomponent
							@endcomponent

						@endslot
						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot
					@endcomponent

				</form>

				<form method="POST" action="{{ route('tenancies.update', $tenancy->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Service
						@endslot
						@slot('body')

							@component('partials.form-group')
								@slot('label')
									Service
								@endslot
								<select name="service_id" id="service_id" class="form-control">
									@foreach (services() as $service)
										<option @if ($tenancy->service->id == $service->id) selected @endif value="{{ $service->id }}">
											{{ $service->present()->selectName }}
										</option>
									@endforeach
								</select>
							@endcomponent

						@endslot
						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot
					@endcomponent

				</form>

				<form method="POST" action="{{ route('tenancies.update', $tenancy->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Correspondence Address
						@endslot
						@slot('body')

							{{-- No property owners --}}
							@if (! count($tenancy->property->owners))

								{{-- No users added as owners warning --}}
								@component('partials.alerts.warning')
									@icon('warning') No users have been added as owners for the property <a href="{{ route('properties.show', $tenancy->property_id) }}">{{ $tenancy->property->present()->shortAddress }}</a>
								@endcomponent

							@else

								@if ($tenancy->hasMultipleLandlordProperties())

									@if (! $tenancy->hasPreferredLandlordProperty())

										@component('partials.alerts.warning')
											@icon('warning') Property owners have different home addresses and no preferred address has been choosen for this tenancy.
										@endcomponent

									@else

										@component('partials.alerts.info')
											{!! $tenancy->getLandlordPropertyAddress() !!}
										@endcomponent

									@endif

									@component('partials.form-group')
										@slot('label')
											Change Preferred Address
										@endslot
										<select name="preferred_landlord_property_id" id="preferred_landlord_property_id" class="form-control">
											<option value="" selected>Please select..</option>
											@foreach ($tenancy->getLandlordPropertiesList() as $property)
												<option value="{{ $property->id }}">
													{{ $property->present()->selectName }}
												</option>
											@endforeach
										</select>
									@endcomponent

								@else

									{{-- No single property--}}
									@if (! $tenancy->hasOneLandlordProperty())

										@component('partials.alerts.warning')
											@icon('warning') The property owners '<b>{{ $tenancy->present()->landlordNames }}</b>' do not have a home address set between them.
										@endcomponent

									@else

										<p class="card-text">
											The following address will be used when creating new statements and invoices for this tenancy.
										</p>

										@component('partials.alerts.info')
											{!! $tenancy->getLandlordPropertyAddress() !!}
										@endcomponent

									@endif

								@endif

							@endif

						@endslot
						@if ($tenancy->hasMultipleLandlordProperties())
							@slot('footer')
								@component('partials.save-button')
									Save Changes
								@endcomponent
							@endslot
						@endif
					@endcomponent

				</form>

			</div>
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('tenancies.update', $tenancy->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Vacating or Vacated
						@endslot

						<div class="card-body">

							@component('partials.form-group')
								@slot('label')
									Date Vacated/Vacating
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" name="vacated_on" id="vacated_on" class="form-control" value="{{ $tenancy->present()->dateInput('vacated_on', old('vacated_on')) }}" />
								@endcomponent
							@endcomponent

						</div>

						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot
					@endcomponent

				</form>


			</div>
		</div>

	@endcomponent

@endsection
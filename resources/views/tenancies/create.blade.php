@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Tenancy
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="card mb-3">
			@component('partials.card-header')
				Tenancy Details
			@endcomponent
			<div class="card-body">

				<form method="POST" action="{{ route('tenancies.store') }}">
					{{ csrf_field() }}

					<div class="form-group">
						<label for="service_id">Service</label>
						<select name="service_id" id="service_id" class="form-control" required>
							@foreach (services() as $service)
								<option @if (old('service_id') == $service->id) selected @endif value="{{ $service->id }}">
									{{ $service->name }}
								</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="property_id">Property</label>
						<select name="property_id" id="property_id" class="form-control select2" required>
							<option value="">Please select..</option>
							@foreach (properties() as $property)
								<option @if (old('property_id') == $property->id) selected @endif value="{{ $property->id }}">
									{{ $property->present()->selectName }}
								</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="tenants">Tenants</label>
						<select name="tenants[]" class="form-control select2" multiple required>
							@foreach (users() as $user)
								<option @if (old('users') && in_array($user->id, old('users'))) selected @endif value="{{ $user->id }}">
									{{ $user->present()->selectName }}
								</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="start_date">Start Date</label>
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required />
						</div>
					</div>

					<div class="form-group">
						<label for="length">Length</label>
						<select name="length" id="length" class="form-control" required>
							<option value="3-months">3 Months</option>
							<option value="6-months">6 Months</option>
							<option value="12-months">12 Months</option>
						</select>
					</div>

					<div class="form-group">
						<label for="rent_amount">Rent Amount</label>
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-money-bill"></i>
							</span>
							<input type="number" step="any" name="rent_amount" id="rent_amount" class="form-control" value="{{ old('rent_amount') }}" required />
						</div>
					</div>

					@component('partials.save-button')
						Create Tenancy
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection
@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">New Tenancy</h1>

			<hr />

			<form role="form" method="POST" action="{{ route('tenancies.store') }}">
				{{ csrf_field() }}

				@include('partials.errors-block')

				<div class="field">
					<label class="label" for="service_id">Service</label>
					<div class="control">
						<span class="select is-fullwidth">
							<select name="service_id">
								<option value="">Please select..</option>
								@foreach (services() as $service)
									<option @if (old('service_id') == $service->id) selected @endif value="{{ $service->id }}">{{ $service->name }}</option>
								@endforeach
							</select>
						</span>
					</div>
				</div>

				<div class="field">
					<label class="label" for="property_id">Property</label>
					<div class="control">
						<select name="property_id" class="select2">
							<option value="">Please select..</option>
							@foreach (properties() as $property)
								<option @if (old('property_id') == $property->id) selected @endif value="{{ $property->id }}">{{ $property->name }}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="field">
					<label class="label" for="users">Tenants</label>
					<div class="control">
						<select name="users[]" class="select2" multiple>
							<option value="">Please select..</option>
							@foreach (users() as $user)
								<option @if (old('users') && in_array($user->id, old('users'))) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="field">
					<label class="label" for="start_date">Start Date</label>
					<div class="control">
						<input type="date" name="start_date" class="input" value="{{ old('start_date') }}" />
					</div>
				</div>

				<div class="field">
					<label class="label" for="length">Length</label>
					<div class="control">
						<span class="select is-fullwidth">
							<select name="length">
								<option value="3-months">3 Months</option>
								<option value="6-months">6 Months</option>
								<option value="12-months">12 Months</option>
							</select>
						</span>
					</div>
				</div>

				<div class="field">
					<label class="label" for="rent_amount">Rent Amount PCM</label>
					<div class="control">
						<input type="number" step="any" name="rent_amount" class="input" value="{{ old('rent_amount') }}" />
					</div>
				</div>

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Create Tenancy
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection
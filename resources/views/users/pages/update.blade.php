@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				@slot('url')
					{{ route('users.show', $user->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $user->present()->fullName }}
		@endcomponent

		@component('partials.sub-header')
			Edit Personal Details
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Update Details
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('users.update', $user->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}			

							@include('users.partials.form')

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

			</div>
			<div class="col-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Set Home Address
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('users.update', $user->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="property_id">Property</label>
								<select name="property_id" id="property_id" class="form-control select2">
									<option value="">None</option>
									@foreach (properties() as $property)
										<option @if ($user->property_id == $property->id) selected @endif value="{{ $property->id }}">
											{{ $property->present()->selectName }}
										</option>
									@endforeach
								</select>
							</div>

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

				<div class="card mb-3">

					@component('partials.card-header')
						Rental Settings
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('users.update', $user->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="tenancy_service_management_discount">Tenancy Management Discount</label>
								<select name="tenancy_service_management_discount" id="tenancy_service_management_discount" class="form-control">
									<option value="">None</option>
									@foreach (discounts() as $discount)
										<option @if (array_has($user->settings, 'tenancy_service_management_discount') && $user->settings['tenancy_service_management_discount'] == $discount->id) selected @endif value="{{ $discount->id }}">{{ $discount->name }}</option>
									@endforeach
								</select>
								<small class="form-text text-muted">
									Set a discount to be applied to the management fee of all new tenancies.
								</small>
							</div>

							<div class="form-group">
								<label for="tenancy_service_letting_fee">Override Letting Fee</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-money-bill"></i>
									</span>
									<input type="text" name="tenancy_service_letting_fee" id="tenancy_service_letting_fee" class="form-control" value="{{ array_has($user->settings, 'tenancy_service_letting_fee') ? $user->settings['tenancy_service_letting_fee'] : '' }}" />
								</div>
								<small class="form-text text-muted">
									Enter the amount that we want to charge this landlord for letting their property.
								</small>
							</div>

							<div class="form-group">
								<label for="tenancy_service_re_letting_fee">Override Re-Letting Fee</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-money-bill"></i>
									</span>
									<input type="text" name="tenancy_service_re_letting_fee" id="tenancy_service_re_letting_fee" class="form-control" value="{{ array_has($user->settings, 'tenancy_service_re_letting_fee') ? $user->settings['tenancy_service_re_letting_fee'] : '' }}" />
								</div>
								<small class="form-text text-muted">
									Enter the amount that we want to charge this landlord for re-letting their property.
								</small>
							</div>

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

				<div class="card mb-3">

					@component('partials.card-header')
						Rental Settings
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('users.update', $user->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="expense_notifications">
									Expense Notifications
								</label>
								<select name="expense_notifications" id="expense_notifications" class="form-control">
									<option @if (!$user->getSetting('expense_notifications')) selected @endif value="">
										None
									</option>
									<option @if ($user->getSetting('expense_notifications') == 'email') selected @endif value="email">
										E-Mail
									</option>
									<option @if ($user->getSetting('expense_notifications') == 'sms') selected @endif value="sms">
										SMS
									</option>
								</select>
							</div>

							<div class="form-group">
								<label for="expense_notifications">
									Rent Payment Notifications
								</label>
								<select name="rent_payment_notifications" id="rent_payment_notifications" class="form-control">
									<option  @if (!$user->getSetting('rent_payment_notifications')) selected @endif value="">
										None
									</option>
									<option @if ($user->getSetting('rent_payment_notifications') == 'email') selected @endif value="email">
										E-Mail
									</option>
									<option @if ($user->getSetting('rent_payment_notifications') == 'sms') selected @endif value="sms">
										SMS
									</option>
								</select>
							</div>

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

			</div>
		</div>

	@endcomponent

@endsection
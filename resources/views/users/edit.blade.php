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

				@if ($user->email)

					<div class="card mb-3">

						@component('partials.card-header')
							Current E-Mail
						@endcomponent

						<div class="card-body">

							<div class="form-group">
								<input type="text" name="current_email" id="current_email" class="form-control" value="{{ $user->email }}" disabled />
							</div>

							<form method="POST" action="{{ route('users.update', $user->id) }}">
								{{ csrf_field() }}
								{{ method_field('PUT') }}

								<input type="hidden" name="email" value="" />

								<button type="submit" class="btn btn-danger" name="remove_email" value="true">
									<i class="fa fa-times"></i> Remove E-Mail
								</button>

							</form>

						</div>
					</div>

				@endif

				<div class="card mb-3">

					@component('partials.card-header')
						Change User E-Mail
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('users.update-email', $user->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="email">New E-Mail</label>
								<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" />
							</div>

							<div class="form-group">
								<label for="email_confirmation">Confirm New E-Mail</label>
								<input type="email" name="email_confirmation" id="email_confirmation" class="form-control" />
							</div>

							@component('partials.save-button')
								Update E-Mail
							@endcomponent

						</form>

					</div>
				</div>

				<div class="card mb-3">

					@component('partials.card-header')
						Change Password
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('users.update-password', $user->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="password">New Password</label>
								<input type="password" class="form-control" name="password" id="password" />
							</div>

							<div class="form-group">
								<label for="password_confirmation">Confirm New Password</label>
								<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" />
							</div>

							<div class="form-check">
								<label class="form-check-label">
									<input type="checkbox" class="form-check-input" name="notify_user" value="true" checked >
									Notify the user that their password has been changed?
								</label>
							</div>

							<div class="form-group">
								<label for="notify_message">Message to User (optional)</label>
								<textarea name="notify_message" id="notify_message" class="form-control" rows="4"></textarea>
								<small class="form-text text-muted">
									Send the user a custom message letting them know why their password was changed.
								</small>
							</div>

							@component('partials.save-button')
								Change Password
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

						@component('partials.alerts.warning')
							Overrwite the charges for new tenancies created for properties this user is the owner of.
						@endcomponent

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
						Contractor Settings
					@endcomponent

					<div class="card-body">

						@component('partials.alerts.warning')
							When this user is assigned as a contractor for an expense the following settings are used.
						@endcomponent

						<form method="POST" action="{{ route('users.update', $user->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="expense_notifications">
									Bank Account
								</label>
								<select name="contractor_bank_account_id" id="contractor_bank_account_id" class="form-control select2">
									<option value="">None</option>
									@foreach (bank_accounts([$user->id]) as $account)
										<option @if ($user->getSetting('contractor_bank_account_id') == $account->id) selected @endif value="{{ $account->id }}">
											{{ $account->present()->selectName }}
										</option>
									@endforeach
								</select>
							</div>

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
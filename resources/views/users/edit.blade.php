@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
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

				<form method="POST" action="{{ route('users.update', $user->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}	

					<div class="card mb-3">

						@component('partials.card-header')
							Update Details
						@endcomponent

						<div class="card-body">		

							@include('users.partials.form')

						</div>
						<div class="card-footer">
							@component('partials.save-button')
								Save Changes
							@endcomponent
						</div>
					</div>

				</form>

				@if ($user->email)

					<form method="POST" action="{{ route('users.update', $user->id) }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}

						<div class="card mb-3">

							@component('partials.card-header')
								Current E-Mail
							@endcomponent

							<div class="card-body">

								@component('partials.form-group')
									<input type="text" name="current_email" id="current_email" class="form-control" value="{{ $user->email }}" disabled />
								@endcomponent

								<input type="hidden" name="email" value="" />

							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-danger" name="remove_email" value="true">
									<i class="fa fa-times"></i> Remove E-Mail
								</button>
							</div>
						</div>

					</form>

				@endif

				<form method="POST" action="{{ route('users.update-email', $user->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					<div class="card mb-3">

						@component('partials.card-header')
							Change User E-Mail
						@endcomponent

						<div class="card-body">

							@component('partials.form-group')
								@slot('label')
									New E-Mail
								@endslot
								<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" />
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Confirm New E-Mail
								@endslot
								<input type="email" name="email_confirmation" id="email_confirmation" class="form-control" />
							@endcomponent

						</div>
						<div class="card-footer">
							@component('partials.save-button')
								Update E-Mail
							@endcomponent
						</div>
					</div>

				</form>

				<form method="POST" action="{{ route('users.update-password', $user->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					<div class="card mb-3">

						@component('partials.card-header')
							Change Password
						@endcomponent

						<div class="card-body">

							@component('partials.form-group')
								@slot('label')
									New Password
								@endslot
								<input type="password" class="form-control" name="password" id="password" />
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Confirm New Password
								@endslot
								<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" />
							@endcomponent

						</div>
						<div class="card-footer">
							@component('partials.save-button')
								Change Password
							@endcomponent
						</div>
					</div>

				</form>

			</div>
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('users.update', $user->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					<div class="card mb-3">

						@component('partials.card-header')
							Set Home Address
						@endcomponent

						<div class="card-body">

							<p class="card-text">
								Select the property where this user is currently living eg. their home address.
							</p>

							@component('partials.form-group')
								<select name="property_id" id="property_id" class="form-control select2">
									<option value="">None</option>
									@foreach (properties() as $property)
										<option @if ($user->property_id == $property->id) selected @endif value="{{ $property->id }}">
											{{ $property->present()->selectName }}
										</option>
									@endforeach
								</select>
							@endcomponent

						</div>
						<div class="card-footer">
							@component('partials.save-button')
								Save Changes
							@endcomponent
						</div>
					</div>

				</form>

				<form method="POST" action="{{ route('users.update', $user->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					<div class="card mb-3">

						@component('partials.card-header')
							Rental Settings
						@endcomponent

						<div class="card-body">

							@component('partials.alerts.info')
								You can set default management discounts or letting and re-letting fees for new tenancies created for properties that this user is the owner of.
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Default Management Discount
								@endslot
								<select name="tenancy_service_management_discount" id="tenancy_service_management_discount" class="form-control">
									<option value="">None</option>
									@foreach (discounts() as $discount)
										<option @if (array_has($user->settings, 'tenancy_service_management_discount') && $user->settings['tenancy_service_management_discount'] == $discount->id) selected @endif value="{{ $discount->id }}">{{ $discount->name }}</option>
									@endforeach
								</select>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Default Letting Fee
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('money')
									@endslot
									<input type="text" name="tenancy_service_letting_fee" id="tenancy_service_letting_fee" class="form-control" value="{{ array_has($user->settings, 'tenancy_service_letting_fee') ? $user->settings['tenancy_service_letting_fee'] : '' }}" />
								@endcomponent
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Default Re-Letting Fee
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('money')
									@endslot
									<input type="text" name="tenancy_service_re_letting_fee" id="tenancy_service_re_letting_fee" class="form-control" value="{{ array_has($user->settings, 'tenancy_service_re_letting_fee') ? $user->settings['tenancy_service_re_letting_fee'] : '' }}" />
								@endcomponent
							@endcomponent

						</div>
						<div class="card-footer">
							@component('partials.save-button')
								Save Changes
							@endcomponent
						</div>
					</div>
				</form>

				<form method="POST" action="{{ route('users.update', $user->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					<div class="card mb-3">

						@component('partials.card-header')
							Contractor Settings
						@endcomponent

						<div class="card-body">

							@component('partials.alerts.info')
								When this user is set as the contractor for an expense, the following settings will apply.
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Bank Account
								@endslot
								<select name="contractor_bank_account_id" id="contractor_bank_account_id" class="form-control select2">
									<option value="">None (Cheque/Cash)</option>
									@foreach (bank_accounts([$user->id]) as $account)
										<option @if ($user->getSetting('contractor_bank_account_id') == $account->id) selected @endif value="{{ $account->id }}">
											{{ $account->present()->selectName }}
										</option>
									@endforeach
								</select>
							@endcomponent

						</div>
						<div class="card-footer">
							@component('partials.save-button')
								Save Changes
							@endcomponent
						</div>
					</div>

				</form>

				<form method="POST" action="{{ route('users.update', $user->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					<div class="card mb-3">
						@component('partials.card-header')
							User Notifications
						@endcomponent
						<div class="card-body">

							@component('partials.form-group')
								@slot('label')
									Expense has been paid to contractor
								@endslot
								<select name="expense_paid_notifications" id="expense_paid_notifications" class="form-control">
									<option @if (!$user->getSetting('expense_paid_notifications')) selected @endif value="">
										None
									</option>
									<option @if ($user->getSetting('expense_paid_notifications') == 'email') selected @endif value="email">
										E-Mail
									</option>
									<option @if ($user->getSetting('expense_paid_notifications') == 'sms') selected @endif value="sms">
										SMS
									</option>
								</select>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Expense has been received to contractor
								@endslot
								<select name="expense_received_notifications" id="expense_received_notifications" class="form-control">
									<option @if (!$user->getSetting('expense_received_notifications')) selected @endif value="">
										None
									</option>
									<option @if ($user->getSetting('expense_received_notifications') == 'email') selected @endif value="email">
										E-Mail
									</option>
									<option @if ($user->getSetting('expense_received_notifications') == 'sms') selected @endif value="sms">
										SMS
									</option>
								</select>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Rent payment received for tenancy
								@endslot
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
							@endcomponent

						</div>
						<div class="card-footer">
							@component('partials.save-button')
								Save Changes
							@endcomponent
						</div>
					</div>

				</form>

			</div>
		</div>

	@endcomponent

@endsection
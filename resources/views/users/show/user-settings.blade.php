@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				{{ $user->name }}
			@endcomponent

			@component('partials.sub-header')
				Update Settings
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('users.update-settings', $user->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="card mb-3">

				@component('partials.card-header')
					Site Settings
				@endcomponent

				<div class="card-body">

					<div class="form-group">
						<label class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" name="dark_mode" value="true" @if (user_setting('dark_mode', $user)) checked @endif />
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description">Enable Dark Mode</span>
						</label>
						<small class="form-text text-muted">
							Enable site wide 'Dark Mode' which will change the colours and style.
						</small>
					</div>

					<div class="form-group">
						<label for="calendar_event_color">Calendar Event Colour</label>
						<input type="text" name="calendar_event_color" class="form-control" value="{{ user_setting('calendar_event_color', $user) ? user_setting('calendar_event_color', $user) : '' }}" />
						<small class="form-text text-muted">
							Choose the colour for events created by this user.
						</small>
					</div>

					<div class="form-group">
						<label for="font_override">Font Override Family</label>
						<input type="text" name="font_override" class="form-control" value="{{ user_setting('font_override', $user) ? user_setting('font_override', $user) : '' }}" />
						<small class="form-text text-muted">
							Override the font for this site. Note that the font you enter must be installed onto the system you are using for it to work.
						</small>
					</div>

					<div class="form-group">
						<label for="font_override_size">Font Override Size</label>
						<input type="text" name="font_override_size" id="font_override_size" class="form-control" value="{{ user_setting('font_override_size', $user) ? user_setting('font_override_size', $user) : '' }}" />
					</div>

				</div>
			</div>

			<div class="card mb-3">

				@component('partials.bootstrap.card-header')
					Tenancy Discount Settings
					<small class="text-muted d-block">
						Set discounts for new tenancies created for properties owned by this user.
					</small>
				@endcomponent

				<div class="card-body">

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
								<i class="fa fa-gbp"></i>
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
								<i class="fa fa-gbp"></i>
							</span>
							<input type="text" name="tenancy_service_re_letting_fee" id="tenancy_service_re_letting_fee" class="form-control" value="{{ array_has($user->settings, 'tenancy_service_re_letting_fee') ? $user->settings['tenancy_service_re_letting_fee'] : '' }}" />
						</div>
						<small class="form-text text-muted">
							Enter the amount that we want to charge this landlord for re-letting their property.
						</small>
					</div>

				</div>
			</div>

			@component('partials.save-button')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

@endsection
<form method="POST" action="{{ route('settings.update') }}">
	{{ csrf_field() }}
	{{ method_field('PUT') }}

	<div class="card mb-3">
		@component('partials.card-header')
			Company Name
		@endcomponent
		<div class="card-body">

			@component('partials.form-group')
				<input type="text" name="company_name" id="company_name" class="form-control" value="{{ get_setting('company_name') }}" />
			@endcomponent

		</div>
		<div class="card-footer">
			@component('partials.save-button')
				Save Changes
			@endcomponent
		</div>
	</div>

	<div class="card mb-3">
		@component('partials.card-header')
			Company User
		@endcomponent
		<div class="card-body">

			<p class="card-text">
				Select a user account to become the business user. Any invoice payments or other business related items will be attached to this user.
			</p>

			@component('partials.form-group')
				<select name="company_user_id" id="company_user_id" class="form-control select2">
					<option value="">None</option>
					@foreach (users() as $user)
						<option @if (get_setting('company_user_id') == $user->id) selected @endif value="{{ $user->id }}">
							{{ $user->present()->selectName }}
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

	<div class="card mb-3">
		@component('partials.card-header')
			Company Bank Account
		@endcomponent
		<div class="card-body">

			<p class="card-text">
				You can select a bank account which should be used for all invoice payments to the business eg. Rental statement invoice payments. This account is also added as the 'pay into' account on invoices sent to users.
			</p>

			@component('partials.form-group')
				<select name="company_bank_account_id" id="company_bank_account_id" class="form-control select2">
					<option value="">None</option>
					@foreach (bank_accounts() as $account)
						<option @if (get_setting('company_bank_account_id') == $account->id) selected @endif value="{{ $account->id }}">
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

<form method="POST" action="{{ route('settings.upload-logo') }}" enctype="multipart/form-data">
	{{ csrf_field() }}

	@component('partials.card')
		@slot('header')
			Company Logo
		@endslot

		<div class="card-body">

			@if (get_setting('company_logo'))
				<div class="row mb-3">
					<div class="col-12 col-lg-5">
						<img class="img-fluid img-thumbnail" src="{{ Storage::url(get_setting('company_logo')) }}" />
					</div>
					@if (get_setting('company_logo_small'))
						<div class="col-12 col-lg-7">
							<img class="img-thumbnail" src="{{ Storage::url(get_setting('company_logo_small')) }}" />
						</div>
					@endif
				</div>

				<hr />
			@endif

			@component('partials.form-group')
				@slot('label')
					Upload @if (get_setting('company_logo')) &amp; replace @endif Logo
				@endslot
				<input type="file" name="company_logo" id="company_logo" class="form-control" />
			@endcomponent

		</div>

		@slot('footer')
			@component('partials.save-button')
				Upload Logo
			@endcomponent
		@endslot
	@endcomponent

</form>
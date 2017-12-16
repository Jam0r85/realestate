<div class="card mb-3">
	@component('partials.card-header')
		Company Settings
	@endcomponent
	<div class="card-body">

		<form role="form" method="POST" action="{{ route('settings.update') }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="form-group">
				<label for="company_name">Company Name</label>
				<input type="text" name="company_name" class="form-control" value="{{ get_setting('company_name') }}" />
			</div>

			<div class="form-group">
				<label for="company_user_id">Company User Account</label>
				<select name="company_user_id" id="company_user_id" class="form-control select2">
					<option value="">None</option>
					@foreach (users() as $user)
						<option @if (get_setting('company_user_id') == $user->id) selected @endif value="{{ $user->id }}">
							{{ $user->present()->selectName }}
						</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="company_bank_account_id">Company Bank Account</label>
				<select name="company_bank_account_id" id="company_bank_account_id" class="form-control select2">
					<option value="">None</option>
					@foreach (bank_accounts() as $account)
						<option @if (get_setting('company_bank_account_id') == $account->id) selected @endif value="{{ $account->id }}">
							{{ $account->present()->selectName }}
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
		Company Logo
	@endcomponent
	<div class="card-body">

	</div>
</div>
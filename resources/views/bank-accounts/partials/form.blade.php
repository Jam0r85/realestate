@component('partials.form-group')
	@slot('label')
		Bank Name
	@endslot
	<input type="text" name="bank_name" id="bank_name" class="form-control" value="{{ isset($account) ? $account->bank_name : old('bank_name') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Account Name
	@endslot
	<input type="text" name="account_name" id="account_name" class="form-control" value="{{ isset($account) ? $account->account_name : old('account_name') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Account Number
	@endslot
	<input type="text" name="account_number" id="account_number" class="form-control" value="{{ isset($account) ? $account->account_number : old('account_number') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Sort Code
	@endslot
	<input type="text" name="sort_code" id="sort_code" class="form-control" value="{{ isset($account) ? $account->sort_code : old('sort_code') }}" />
@endcomponent
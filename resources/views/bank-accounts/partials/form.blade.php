<div class="form-group">
	<label for="bank_name">Bank Name</label>
	<input type="text" name="bank_name" class="form-control" value="{{ isset($account) ? $account->bank_name : old('bank_name') }}" />
</div>

<div class="form-group">
	<label for="account_name">Account Name</label>
	<input type="text" name="account_name" class="form-control" value="{{ isset($account) ? $account->account_name : old('account_name') }}" />
</div>

<div class="form-group">
	<label for="account_number">Account Number</label>
	<input type="text" name="account_number" class="form-control" value="{{ isset($account) ? $account->account_number : old('account_number') }}" />
</div>

<div class="form-group">
	<label for="sort_code">Sort Code</label>
	<input type="text" name="sort_code" class="form-control" value="{{ isset($account) ? $account->sort_code : old('sort_code') }}" />
</div>
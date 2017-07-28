<div class="field">
	<label class="label" for="bank_name">Bank Name</label>
	<p class="control">
		<input type="text" name="bank_name" class="input" value="{{ isset($account) ? $account->bank_name : old('bank_name') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="account_name">Account Name</label>
	<p class="control">
		<input type="text" name="account_name" class="input" value="{{ isset($account) ? $account->account_name : old('account_name') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="account_number">Account Number</label>
	<p class="control">
		<input type="text" name="account_number" class="input" value="{{ isset($account) ? $account->account_number : old('account_number') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="sort_code">Sort Code</label>
	<p class="control">
		<input type="text" name="sort_code" class="input" value="{{ isset($account) ? $account->sort_code : old('sort_code') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="users">Users</label>
	<p class="control">
		<select name="users[]" class="select2" multiple>
			@foreach (users() as $user)
				<option value="{{ $user->id }}">{{ $user->name }}</option>
			@endforeach
		</select>
	</p>
</div>
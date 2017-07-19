<div class="field">
	<label class="label" for="name">
		Branch Name
	</label>
	<p class="control">
		<input type="text" name="name" class="input" value="{{ isset($branch) ? $branch->name : old('name') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="email">
		E-Mail Address
	</label>
	<p class="control">
		<input type="email" name="email" class="input" value="{{ isset($branch) ? $branch->email : old('email') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="phone_number">
		Phone Number
	</label>
	<p class="control">
		<input type="text" name="phone_number" class="input" value="{{ isset($branch) ? $branch->phone_number : old('phone_number') }}" />
	</p>
</div>
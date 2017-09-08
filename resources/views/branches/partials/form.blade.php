<div class="form-group">
	<label for="name">
		Branch Name
	</label>
	<input type="text" name="name" class="form-control" value="{{ isset($branch) ? $branch->name : old('name') }}" />
</div>

<div class="form-group">
	<label for="email">
		E-Mail Address
	</label>
	<input type="email" name="email" class="form-control" value="{{ isset($branch) ? $branch->email : old('email') }}" />
</div>

<div class="form-group">
	<label for="phone_number">
		Phone Number
	</label>
	<input type="text" name="phone_number" class="form-control" value="{{ isset($branch) ? $branch->phone_number : old('phone_number') }}" />
</div>

<div class="form-group">
	<label for="address">
		Address
	</label>
	<textarea name="address" rows="6" class="form-control">{{ isset($branch) ? $branch->address : old('address') }}</textarea>
</div>
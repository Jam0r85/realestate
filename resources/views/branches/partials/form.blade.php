<div class="form-group">
	<label for="name">
		Branch Name
	</label>
	<input type="text" name="name" id="name" class="form-control" value="{{ isset($branch) ? $branch->name : old('name') }}" />
</div>

<div class="form-group">
	<label for="email">
		E-Mail Address
	</label>
	<input type="email" name="email" id="email" class="form-control" value="{{ isset($branch) ? $branch->email : old('email') }}" />
</div>

<div class="form-group">
	<label for="phone_number">
		Phone Number
	</label>
	<input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ isset($branch) ? $branch->phone_number : old('phone_number') }}" />
</div>

<div class="form-group">
	<label for="address">
		Address
	</label>
	<textarea name="address" rows="6" id="address" class="form-control">{{ isset($branch) ? $branch->address : old('address') }}</textarea>
</div>

<div class="form-group">
	<label for="vat_number">
		VAT Number
	</label>
	<input type="text" name="vat_number" id="vat_number" class="form-control" value="{{ isset($branch) ? $branch->vat_number : old('vat_number') }}" />
</div>
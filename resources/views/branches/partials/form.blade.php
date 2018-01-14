@component('partials.form-group')
	@slot('label')
		Branch Name
	@endslot
	@slot('help')
		Used both privately and publically. Usually the town name the branch is situated in.
	@endslot
	<input type="text" name="name" id="name" class="form-control" required value="{{ isset($branch) ? $branch->name : old('name') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Contact E-Mail
	@endslot
	@slot('help')
		The primary contact e-mail address for the branch.
	@endslot
	<input type="email" name="email" id="email" class="form-control" required value="{{ isset($branch) ? $branch->email : old('email') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Contact Phone Number
	@endslot
	@slot('help')
		The primary contact telephone number for the branch.
	@endslot
	<input type="text" name="phone_number" id="phone_number" class="form-control" required value="{{ isset($branch) ? $branch->phone_number : old('phone_number') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Address
	@endslot
	@slot('help')
		The full address for the office of the branch.
	@endslot
	<textarea name="address" rows="6" id="address" class="form-control" required>{{ isset($branch) ? $branch->address : old('address') }}</textarea>
@endcomponent

@component('partials.form-group')
	@slot('label')
		VAT Number
	@endslot
	@slot('help')
		UK only, the VAT number for the branch.
	@endslot
	<input type="text" name="vat_number" id="vat_number" class="form-control" value="{{ isset($branch) ? $branch->vat_number : old('vat_number') }}" />
@endcomponent
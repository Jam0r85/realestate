@component('partials.form-group')
	@slot('label')
		Branch Name
	@endslot
	<input type="text" name="name" id="name" class="form-control" value="{{ isset($branch) ? $branch->name : old('name') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Contact E-Mail
	@endslot
	<input type="email" name="email" id="email" class="form-control" value="{{ isset($branch) ? $branch->email : old('email') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Contact Phone Number
	@endslot
	<input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ isset($branch) ? $branch->phone_number : old('phone_number') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Address
	@endslot
	<textarea name="address" rows="6" id="address" class="form-control">{{ isset($branch) ? $branch->address : old('address') }}</textarea>
@endcomponent

@component('partials.form-group')
	@slot('label')
		VAT Number
	@endslot
	<input type="text" name="vat_number" id="vat_number" class="form-control" value="{{ isset($branch) ? $branch->vat_number : old('vat_number') }}" />
@endcomponent
@component('partials.form-group')
	@slot('label')
		Role Name
	@endslot
	<input type="text" name="name" id="name" class="form-control" value="{{ isset($role) ? $role->name : old('name') }}" />
@endcomponent
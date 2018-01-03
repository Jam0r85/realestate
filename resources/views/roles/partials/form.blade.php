@component('partials.form-group')
	@slot('label')
		Role Name
	@endslot
	<input type="text" name="name" id="name" class="form-control" value="{{ isset($role) ? $role->name : old('name') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Description
	@endslot
	<textarea name="description" id="description" class="form-control" rows="6">{{ isset($role) ? $role->description : old('description') }}</textarea>
@endcomponent
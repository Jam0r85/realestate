@component('partials.form-group')
	@slot('label')
		Permission Name
	@endslot
	<input type="text" name="name" id="name" class="form-control" value="{{ isset($permission) ? $permission->name : old('name') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Permission Slug
	@endslot
	<input type="text" name="slug" id="slug" class="form-control" value="{{ isset($permission) ? $permission->slug : old('name') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Description
	@endslot
	<textarea name="description" id="description" class="form-control" rows="6">{{ isset($permission) ? $permission->description : old('description') }}</textarea>
@endcomponent
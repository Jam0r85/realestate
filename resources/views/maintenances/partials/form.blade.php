@component('partials.form-group')
	@slot('label')
		Name
	@endslot
	<input type="text" name="name" id="name" class="form-control" value="{{ isset($issue) ? $issue->name : old('name') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Description
	@endslot
	<textarea name="description" id="description" class="form-control" rows="6">{{ isset($issue) ? $issue->description : old('description') }}</textarea>
@endcomponent
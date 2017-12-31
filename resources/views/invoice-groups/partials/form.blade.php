@component('partials.form-group')
	@slot('label')
		Name
	@endslot
	<input class="form-control" type="text" name="name" id="name" value="{{ isset($group) ? $group->name : old('name') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Format
	@endslot
	@slot('help')
		Use @{{number}} to postion the invoice number.
	@endslot
	<input class="form-control" type="text" name="format" id="format" value="{{ isset($group) ? $group->format : old('format') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Next Invoice Number
	@endslot
	<input class="form-control" type="number" name="next_number" id="next_number" value="{{ isset($group) ? $group->next_number : old('next_number') }}" />
@endcomponent
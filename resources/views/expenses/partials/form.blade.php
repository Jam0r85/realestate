@component('partials.form-group')
	@slot('label')
		Property
	@endslot
	<select name="property_id" id="property_id" class="form-control select2">
		<option value="">Please select..</option>
		@foreach(properties() as $property)
			<option @if (isset($expense) && $expense->property_id == $property->id) selected @endif value="{{ $property->id }}">
				{{ $property->present()->selectName }}
			</option>
		@endforeach
	</select>
@endcomponent

@component('partials.form-group')
	@slot('label')
		Name
	@endslot
	<input class="form-control" type="text" name="name" id="name" value="{{ isset($expense) ? $expense->name : old('name') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Cost
	@endslot
	<input class="form-control" type="number" step="any" name="cost" id="cost" value="{{ isset($expense) ? pence_to_pounds($expense->cost) : old('cost') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Contractor
	@endslot
	<select name="contractor_id" id="contractor_id" class="form-control select2">
		<option value="">None</option>
		@foreach (users() as $user)
			<option @if (isset($expense) && $expense->contractor_id == $user->id) selected @endif value="{{ $user->id }}">
				{{ $user->present()->selectName }}
			</option>
		@endforeach
	</select>
@endcomponent

@component('partials.form-group')
	@slot('label')
		Invoice Number
	@endslot
	@slot('help')
		The invoice number or reference on the invoice received.
	@endslot
	<input class="form-control" type="text" name="contractor_reference" id="contractor_reference" value="{{ isset($expense) ? $expense->getData('contractor_reference') : old('contractor_reference') }}" />
@endcomponent
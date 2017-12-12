<div class="form-group">
	<label for="property_id">Property</label>
	<select name="property_id" id="property_id" class="form-control select2">
		<option value="">Please select..</option>
		@foreach(properties() as $property)
			<option @if (isset($expense) && $expense->property_id == $property->id) selected @endif value="{{ $property->id }}">
				{{ $property->present()->selectName }}
			</option>
		@endforeach
	</select>
</div>	

<div class="form-group">
	<label for="name">Name</label>
	<input class="form-control" type="text" name="name" id="nane" value="{{ isset($expense) ? $expense->name : old('name') }}" />
</div>

<div class="form-group">
	<label for="cost">Cost</label>
	<input class="form-control" type="number" step="any" name="cost" id="cost" value="{{ isset($expense) ? $expense->cost : old('cost') }}" />
</div>

<div class="form-group">
	<label for="contractor_id">Contractor</label>
	<select name="contractor_id" id="contractor_id" class="form-control select2">
		<option value="">None</option>
		@foreach (users() as $user)
			<option @if (isset($expense) && $expense->contractor_id == $user->id) selected @endif value="{{ $user->id }}">
				{{ $user->present()->selectName }}
			</option>
		@endforeach
	</select>
</div>

<div class="form-group">
	<label for="contractor_reference">Invoice Number (optional)</label>
	<input class="form-control" type="text" name="contractor_reference" id="contractor_reference" value="{{ isset($expense) ? $expense->getData('contractor_reference') : old('contractor_reference') }}" />
	<small class="form-text text-muted">
		Enter the invoice or reference number for this expense received from the contractor.
	</small>
</div>
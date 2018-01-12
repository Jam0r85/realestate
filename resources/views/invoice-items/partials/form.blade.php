@component('partials.form-group')
	@slot('label')
		Item Name
	@endslot
	<input type="text" name="name" id="name" class="form-control" required value="{{ isset($item) ? $item->name : old('name') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Description
	@endslot
	<textarea rows="6" name="description" id="description" class="form-control">{{ isset($item) ? $item->description : old('description') }}</textarea>
@endcomponent

@component('partials.form-group')
	@slot('label')
		Amount Per Item
	@endslot
	<input type="number" step="any" name="amount" id="amount" class="form-control" required value="{{ pence_to_pounds(isset($item) ? $item->amount : old('amount')) }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Quantity
	@endslot
	<input type="number" name="quantity" id="quantity" class="form-control" required value="{{ isset($item) ? $item->quantity : old('quantity') }}" />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Tax Rate
	@endslot
	<select name="tax_rate_id" id="tax_rate_id" class="form-control" required>
		<option value="0" selected>None</option>
		@foreach (tax_rates() as $rate)
			<option @if (isset($item) && $item->tax_rate_id == $rate->id) selected @endif value="{{ $rate->id }}">
				{{ $rate->name }}
			</option>
		@endforeach
	</select>
@endcomponent
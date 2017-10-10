<div class="form-group">
	<label for="{{ isset($array) ? 'item_name' : 'name' }}">Name</label>
	<input type="text" name="{{ isset($array) ? 'item_name[]' : 'name' }}" class="form-control" required 
		@if (!isset($array))
			value="{{ isset($item) ? $item->name : old('name') }}"
		@endif
		@if (isset($data))
			value="{{ $data['name'] }}"
		@endif
	/>
</div>

<div class="form-group">
	<label for="{{ isset($array) ? 'item_description' : 'description' }}">Description (optional)</label>
	<textarea rows="6" name="{{ isset($array) ? 'item_description[]' : 'description' }}" class="form-control">{{ isset($item) ? $item->description : old('description') }}{{ isset($data) ? $data['description'] : '' }}</textarea>
</div>

<div class="form-group">
	<label for="{{ isset($array) ? 'item_amount[]' : 'amount' }}">Amount Per Item</label>
	<input type="number" step="any" name="{{ isset($array) ? 'item_amount[]' : 'amount' }}" class="form-control" required
		@if (!isset($array))
			value="{{ isset($item) ? $item->amount : old('amount') }}"
		@endif
		@if (isset($data))
			value="{{ $data['amount'] }}"
		@endif
	/>
</div>

<div class="form-group">
	<label for="{{ isset($array) ? 'item_quantity' : 'quantity' }}">Quantity</label>
	<input type="number" name="{{ isset($array) ? 'item_quantity[]' : 'quantity' }}" class="form-control" required 
		@if (!isset($array))
			value="{{ isset($item) ? $item->quantity : old('quantity') }}"
		@endif
		@if (isset($data))
			value="{{ $data['quantity'] }}"
		@endif
	/>
</div>

<div class="form-group">
	<label for="{{ isset($array) ? 'item_tax_rate_id[]' : 'tax_rate_id' }}">Tax Rate</label>
	<select name="{{ isset($array) ? 'item_tax_rate_id[]' : 'tax_rate_id' }}" class="form-control" required>
		<option value="0" selected>None</option>
		@foreach (tax_rates() as $rate)
			<option 
				@if (isset($item) && $item->tax_rate_id == $rate->id) selected @endif
				@if (get_setting('default_tax_rate_id') == $rate->id) selected @endif
				value="{{ $rate->id }}">{{ $rate->name }}
			</option>
		@endforeach
	</select>
</div>
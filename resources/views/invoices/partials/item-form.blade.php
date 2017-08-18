<div class="field">
	<label class="label" for="{{ isset($array) ? 'item_name' : 'name' }}">Name</label>
	<p class="control">
		<input type="text" name="{{ isset($array) ? 'item_name[]' : 'name' }}" class="input" 
			@if (!isset($array))
				value="{{ isset($item) ? $item->name : old('name') }}"
			@endif
			@if (isset($data))
				value="{{ $data['name'] }}"
			@endif
		/>
	</p>
</div>

<div class="field">
	<label class="label" for="{{ isset($array) ? 'item_description' : 'description' }}">Description</label>
	<p class="control">
		<textarea name="{{ isset($array) ? 'item_description[]' : 'description' }}" class="textarea">{{ isset($item) ? $item->description : old('description') }}{{ isset($data) ? $data['description'] : '' }}</textarea>
	</p>
</div>

<div class="field">
	<label class="label" for="{{ isset($array) ? 'item_amount[]' : 'amount' }}">Amount Per Item</label>
	<p class="control">
		<input type="number" step="any" name="{{ isset($array) ? 'item_amount[]' : 'amount' }}" class="input" 
			@if (!isset($array))
				value="{{ isset($item) ? $item->amount : old('amount') }}"
			@endif
		/>
	</p>
</div>

<div class="field">
	<label class="label" for="{{ isset($array) ? 'item_quantity' : 'quantity' }}">Quantity</label>
	<p class="control">
		<input type="number" name="{{ isset($array) ? 'item_quantity[]' : 'quantity' }}" class="input" 
			@if (!isset($array))
				value="{{ isset($item) ? $item->quantity : old('quantity') }}"
			@endif
			@if (isset($data))
				value="{{ $data['quantity'] }}"
			@endif
		/>
	</p>
</div>

<div class="field">
	<label class="label" for="{{ isset($array) ? 'item_tax_rate_id[]' : 'tax_rate_id' }}">Tax Rate</label>
	<p class="control is-expanded">
		<span class="select is-fullwidth">
			<select name="{{ isset($array) ? 'item_tax_rate_id[]' : 'tax_rate_id' }}">
				<option value="0" selected>None</option>
				@foreach (tax_rates() as $rate)
					<option 
						@if (isset($item) && $item->tax_rate_id == $rate->id) selected @endif
						@if (get_setting('default_tax_rate_id') == $rate->id) selected @endif
						value="{{ $rate->id }}">{{ $rate->name_formatted }}
					</option>
				@endforeach
			</select>
		</span>
	</p>
</div>
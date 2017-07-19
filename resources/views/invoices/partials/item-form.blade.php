<div class="field">
	<label class="label" for="name">Name</label>
	<p class="control">
		<input type="text" name="name" class="input" value="{{ isset($item) ? $item->name : old('name') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="description">Description</label>
	<p class="control">
		<textarea name="description" class="textarea">{{ isset($item) ? $item->description : old('description') }}</textarea>
	</p>
</div>

<div class="field">
	<label class="label" for="amount">Amount Per Item</label>
	<p class="control">
		<input type="number" step="any" name="amount" class="input" value="{{ isset($item) ? $item->amount : old('amount') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="quantity">Quantity</label>
	<p class="control">
		<input type="number" name="quantity" class="input" value="{{ isset($item) ? $item->quantity : old('quantity') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="tax_rate_id">Tax Rate</label>
	<p class="control is-expanded">
		<span class="select is-fullwidth">
			<select name="tax_rate_id">
				<option value="0" selected>None</option>
				@foreach (tax_rates() as $rate)
					<option @if (isset($item) && $item->tax_rate_id == $rate->id) selected @endif value="{{ $rate->id }}">{{ $rate->name_formatted }}</option>
				@endforeach
			</select>
		</span>
	</p>
</div>
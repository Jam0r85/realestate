<div class="form-group">
	<label for="name">Name</label>
	<input type="text" name="name" class="form-control" value="{{ isset($service) ? $service->name : old('name') }}" required />
</div>

<div class="form-group">
	<label for="description">Description</label>
	<textarea name="description" class="form-control">{{ isset($service) ? $service->description : old('description') }}</textarea>
</div>

<div class="form-group">
	<label for="letting_fee">Letting Fee</label>
	<input type="number" step="any" name="letting_fee" class="form-control" value="{{ isset($service) ? $service->letting_fee : old('letting_fee') }}" />
</div>

<div class="form-group">
	<label for="re_letting_fee">Re-Letting Fee</label>
	<input type="number" step="any" name="re_letting_fee" class="form-control" value="{{ isset($service) ? $service->re_letting_fee : old('re_letting_fee') }}" />
</div>

<div class="form-group">
	<label for="charge">Management Charge</label>
	<input type="number" step="any" name="charge" class="form-control" value="{{ isset($service) ? $service->charge : old('charge') }}" />
	<span class="form-text text-muted">
		Enter the figure in either currency or as a percentage decimal.
	</span>
</div>

<div class="form-group">
	<label for="tax_rate_id">Tax Rate</label>
	<select name="tax_rate_id" class="form-control">
		<option value="0">None</option>
		@foreach (tax_rates() as $rate)
			<option @if (isset($service) && $service->tax_rate_id == $rate->id) selected @endif value="{{ $rate->id }}">
				{{ $rate->name }}
			</option>
		@endforeach
	</select>
	<small class="form-text text-muted">
		Tax rate is applied to all the above amounts.
	</small>
</div>
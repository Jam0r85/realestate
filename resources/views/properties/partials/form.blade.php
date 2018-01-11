<div class="form-group">
	<label for="house_name">House Name</label>
	<input type="text" name="house_name" id="house_name" class="form-control" value="{{ isset($property) ? $property->house_name : old('house_name') }}" />
</div>

<div class="form-group">
	<label for="house_number">House Number</label>
	<input type="text" name="house_number" id="house_number" class="form-control" value="{{ isset($property) ? $property->house_number : old('house_number') }}" />
</div>

<div class="form-group">
	<label for="address1">Address Line 1</label>
	<input type="text" name="address1" id="address1" class="form-control" value="{{ isset($property) ? $property->address1 : old('address1') }}" />
</div>

<div class="form-group">
	<label for="address2">Address Line 2</label>
	<input type="text" name="address2" id="address2" class="form-control" value="{{ isset($property) ? $property->address2 : old('address2') }}" />
</div>

<div class="form-group">
	<label for="address3">Address Line 3</label>
	<input type="text" name="address3" id="address3" class="form-control" value="{{ isset($property) ? $property->address3 : old('address3') }}" />
</div>

<div class="form-group">
	<label for="town">Town</label>
	<input type="text" name="town" id="town" class="form-control" value="{{ isset($property) ? $property->town : old('town') }}" required />
</div>

<div class="form-group">
	<label for="county">County</label>
	<input type="text" name="county" id="county" class="form-control" value="{{ isset($property) ? $property->county : old('county') }}" />
</div>

<div class="form-group">
	<label for="postcode">Post Code</label>
	<input type="text" name="postcode" id="postcode" class="form-control" value="{{ isset($property) ? $property->postcode : old('postcode') }}" required />
</div>

@component('partials.form-group')
	@slot('label')
		Country
	@endslot
	<select name="country" id="country" class="form-control select2">
		@foreach (countries() as $country)
			<option 
				@if (isset($property) && $property->country == $country->name->common) selected
				@elseif (get_setting('default_country') == $country->name->common) selected
				@endif
				>
				{{ $country->name->common }}
			</option>
		@endforeach
	</select>
@endcomponent

<div class="form-group">
	<label for="tax_band_id">
		Tax Band
	</label>
	<select name="tax_band_id" id="tax_band_id" class="form-control">
		<option value="">None</option>
		@foreach (tax_bands() as $band)
			<option @if (isset($property) && $property->tax_band_id == $band->id) selected @endif value="{{ $band->id }}">
				{{ $band->name }}
			</option>
		@endforeach
	</select>
</div>

<div class="form-group">
	<label for="owners">Owners</label>
	<select name="owners[]" id="owners" class="form-control select2" multiple>
		@foreach (users() as $user)
			<option @if (isset($property) && $property->owners->contains($user->id)) selected @endif value="{{ $user->id }}">
				{{ $user->present()->selectName }}
			</option>
		@endforeach
	</select>
</div>
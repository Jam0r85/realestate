<div class="field">
	<label class="label" for="house_name">House Name</label>
	<p class="control">
		<input type="text" name="house_name" class="input" value="{{ isset($property) ? $property->house_name : old('house_name') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="house_number">House Number</label>
	<p class="control">
		<input type="text" name="house_number" class="input" value="{{ isset($property) ? $property->house_number : old('house_number') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="address1">Address Line 1</label>
	<p class="control">
		<input type="text" name="address1" class="input" value="{{ isset($property) ? $property->address1 : old('address1') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="address2">Address Line 2</label>
	<p class="control">
		<input type="text" name="address2" class="input" value="{{ isset($property) ? $property->address2 : old('address2') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="address3">Address Line 3</label>
	<p class="control">
		<input type="text" name="address3" class="input" value="{{ isset($property) ? $property->address3 : old('address3') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="town">Town</label>
	<p class="control">
		<input type="text" name="town" class="input" value="{{ isset($property) ? $property->town : old('town') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="county">County</label>
	<p class="control">
		<input type="text" name="county" class="input" value="{{ isset($property) ? $property->county : old('county') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="postcode">Post Code</label>
	<p class="control">
		<input type="text" name="postcode" class="input" value="{{ isset($property) ? $property->postcode : old('postcode') }}" />
	</p>
</div>
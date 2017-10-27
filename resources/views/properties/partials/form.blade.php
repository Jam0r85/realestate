<div class="form-group">
	<label for="house_name">House Name</label>
	<input type="text" name="house_name" class="form-control" value="{{ isset($property) ? $property->house_name : old('house_name') }}" />
</div>

<div class="form-group">
	<label for="house_number">House Number</label>
	<input type="text" name="house_number" class="form-control" value="{{ isset($property) ? $property->house_number : old('house_number') }}" />
</div>

<div class="form-group">
	<label for="address1">Address Line 1</label>
	<input type="text" name="address1" class="form-control" value="{{ isset($property) ? $property->address1 : old('address1') }}" />
</div>

<div class="form-group">
	<label for="address2">Address Line 2</label>
	<input type="text" name="address2" class="form-control" value="{{ isset($property) ? $property->address2 : old('address2') }}" />
</div>

<div class="form-group">
	<label for="address3">Address Line 3</label>
	<input type="text" name="address3" class="form-control" value="{{ isset($property) ? $property->address3 : old('address3') }}" />
</div>

<div class="form-group">
	<label for="town">Town</label>
	<input type="text" name="town" class="form-control" value="{{ isset($property) ? $property->town : old('town') }}" required />
</div>

<div class="form-group">
	<label for="county">County</label>
	<input type="text" name="county" class="form-control" value="{{ isset($property) ? $property->county : old('county') }}" />
</div>

<div class="form-group">
	<label for="postcode">Post Code</label>
	<input type="text" name="postcode" class="form-control" value="{{ isset($property) ? $property->postcode : old('postcode') }}" required />
</div>
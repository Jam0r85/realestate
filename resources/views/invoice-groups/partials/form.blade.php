<div class="form-group">
	<label for="name">Name</label>
	<input class="form-control" type="text" name="name" value="{{ old('name') }}" />
</div>

<div class="form-group">
	<label for="format">Name Format</label>
	<input class="form-control" type="text" name="format" value="{{ old('format') }}" />
	<small class="form-text text-muted">
		Use {{number}} to postion the invoice number.
	</small>
</div>

<div class="form-group">
	<label for="next_number">Starting Number</label>
	<input class="form-control" type="number" name="next_number" value="{{ old('next_number') }}" />
	<small class="form-text text-muted">
		Enter the starting invoice group number.
	</small>
</div>
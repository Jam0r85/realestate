<div class="form-group">
	<label for="name">Name</label>
	<input class="form-control" type="text" name="name" id="nane" value="{{ $expense->name }}" />
</div>

<div class="form-group">
	<label for="cost">Cost</label>
	<input class="form-control" type="number" step="any" name="cost" id="cost" value="{{ $expense->cost }}" />
</div>

<div class="form-group">
	<label for="contractor_id">Contractor</label>
	<select name="contractor_id" id="contractor_id" class="form-control select2">
		@foreach (users() as $user)
			<option @if ($expense->contractor_id == $user->id) selected @endif value="{{ $user->id }}">
				{{ $user->name }}
			</option>
		@endforeach
	</select>
</div>
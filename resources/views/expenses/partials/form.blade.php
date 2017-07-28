<div class="field">
	<label class="label" for="name">Name</label>
	<p class="control">
		<input type="text" name="name" class="input" value="{{ isset($expense) ? $expense->name : old('name') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="cost">Cost</label>
	<p class="control">
		<input type="number" step="any" class="input" name="cost" value="{{ isset($expense) ? $expense->cost : old('cost') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="contractors">Contractors</label>
	<p class="control">
		<select name="contractors" class="select2" multiple>
			@foreach (users() as $user)
				<option value="{{ $user->id }}">{{ $user->name }}</option>
			@endforeach
		</select>
	</p>
</div>
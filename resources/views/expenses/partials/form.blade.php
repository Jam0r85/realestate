<div class="field">
	<label class="label" for="{{ isset($array) ? 'expense_name' : 'name' }}">Name</label>
	<p class="control">
		<input type="text" name="{{ isset($array) ? 'expense_name[]' : 'name' }}" class="input" 
			@if (!isset($array))
				value="{{ isset($expense) ? $expense->name : old('name') }}"
			@endif
		/>
	</p>
</div>

<div class="field">
	<label class="label" for="{{ isset($array) ? 'expense_cost' : 'cost' }}">Cost</label>
	<p class="control">
		<input type="number" step="any" class="input" name="{{ isset($array) ? 'expense_cost[]' : 'cost' }}" 
			@if (!isset($array))
				value="{{ isset($expense) ? $expense->cost : old('cost') }}"
			@endif
		/>
	</p>
</div>

<div class="field">
	<label class="label" for="{{ isset($array) ? 'expense_contractors' : 'contractors' }}">Contractors</label>
	<p class="control">
		<select name="{{ isset($array) ? 'expense_contractors[]' : 'contractors' }}" class="select2" multiple>
			@foreach (users() as $user)
				<option value="{{ $user->id }}">{{ $user->name }}</option>
			@endforeach
		</select>
	</p>
</div>
<div class="field">
	<label class="label" for="{{ isset($array) ? 'expense_name' : 'name' }}">Name</label>
	<div class="control">
		<input type="text" name="{{ isset($array) ? 'expense_name[]' : 'name' }}" class="input" 
			@if (!isset($array))
				value="{{ isset($expense) ? $expense->name : old('name') }}"
			@endif
		/>
	</div>
</div>

<div class="field">
	<label class="label" for="{{ isset($array) ? 'expense_cost' : 'cost' }}">Cost</label>
	<div class="control">
		<input type="number" step="any" class="input" name="{{ isset($array) ? 'expense_cost[]' : 'cost' }}" 
			@if (!isset($array))
				value="{{ isset($expense) ? $expense->cost : old('cost') }}"
			@endif
		/>
	</div>
</div>

<div class="field">
	<label class="label" for="{{ isset($array) ? 'expense_contractors' : 'contractors' }}">Contractors</label>
	<div class="control">
		<select name="{{ isset($array) ? 'expense_contractors[]' : 'contractors' }}" class="select2" multiple>
			@foreach (users() as $user)
				<option 
					@if (old('contractors') && in_array($user->id, old('contractors'))) selected @endif
					value="{{ $user->id }}">
						{{ $user->name }}
				</option>
			@endforeach
		</select>
	</div>
</div>
<div class="form-group">
	<label for="{{ isset($array) ? 'expense_name' : 'name' }}">Name</label>
	<input class="form-control" type="text" name="{{ isset($array) ? 'expense_name[]' : 'name' }}"  
		@if (!isset($array))
			value="{{ isset($expense) ? $expense->name : old('name') }}"
		@endif
	/>
</div>

<div class="form-group">
	<label for="{{ isset($array) ? 'expense_cost' : 'cost' }}">Cost</label>
	<input class="form-control" type="number" step="any" name="{{ isset($array) ? 'expense_cost[]' : 'cost' }}" 
		@if (!isset($array))
			value="{{ isset($expense) ? $expense->cost : old('cost') }}"
		@endif
	/>
</div>

<div class="form-group">
	<label for="{{ isset($array) ? 'expense_contractors' : 'contractors' }}">Contractors</label>
	<select name="{{ isset($array) ? 'expense_contractors[]' : 'contractors' }}" class="form-control select2" multiple>
		@foreach (users() as $user)
			<option 
				@if (old('contractors') && in_array($user->id, old('contractors'))) selected @endif
				value="{{ $user->id }}">
					{{ $user->name }}
			</option>
		@endforeach
	</select>
</div>
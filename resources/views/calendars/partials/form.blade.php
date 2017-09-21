<div class="form-group">
	<label for="name">Name</label>
	<input type="text" name="name" class="form-control" value="{{ isset($calendar) ? $calendar->name : old('name') }}" />
</div>

<div class="form-group">
	<label for="is_private">Access</label>
	<select name="is_private" class="form-control">
		<option @if (old('is_private') == 0) selected @endif value="0">Public</option>
		<option @if (old('is_private') == 1) selected @endif value="1">Private</option>
	</select>
</div>

<div class="form-group">
	<label for="branch_id">Branch</label>
	@if (branchesCount())
		<select name="branch_id" class="form-control">
			<option value="" disabled selected>Please select..</option>
			@foreach (branches() as $branch)
				<option @if (isset($calendar) && $calendar->branch_id == $branch->id) selected @endif value="{{ $branch->id }}">{{ $branch->name }}</option>
			@endforeach
		</select>
	@else
		<span class="is-error">No branches have been registered.</span>
	@endif
</div>
<div class="field">
	<label class="label" for="name">Name</label>
	<p class="control">
		<input type="text" name="name" class="input" value="{{ isset($calendar) ? $calendar->name : old('name') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="is_private">Access</label>
	<p class="control is-expanded">

		<span class="select is-fullwidth">
			<select name="is_private">
				<option @if (old('is_private') == 0) selected @endif value="0">Public</option>
				<option @if (old('is_private') == 1) selected @endif value="1">Private</option>
			</select>
		</span>

	</p>
</div>

<div class="field">
	<label class="label" for="branch_id">Branch</label>
	<p class="control is-expanded">

		@if (branchesCount())
			<span class="select is-fullwidth">
				<select name="branch_id">
					<option value="" disabled selected>Please select..</option>
					@foreach (branches() as $branch)
						<option @if (isset($calendar) && $calendar->branch_id == $branch->id) selected @endif value="{{ $branch->id }}">{{ $branch->name }}</option>
					@endforeach
				</select>
			</span>
		@else
			<span class="is-error">No branches have been registered.</span>
		@endif

	</p>
</div>
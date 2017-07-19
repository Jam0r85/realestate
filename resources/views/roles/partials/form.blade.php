<div class="field">
	<label class="label" for="name">Name</label>
	<p class="control">
		<input type="text" name="name" class="input" />
	</p>
</div>

<div class="field">
	<label class="label" for="description">Description</label>
	<p class="control">
		<textarea name="description" class="textarea"></textarea>
	</p>
</div>

<div class="field">
	<label class="label" for="branch_id">Branch</label>
	<p class="control">

		@if (branchesCount())

			<span class="select">
				<select name="branch_id">
					<option value="" disabled selected>Please select..</option>
					@foreach (branches() as $branch)
						<option value="{{ $branch->id }}">{{ $branch->name }}</option>
					@endforeach
				</select>
			</span>

		@else
			<span class="is-error">No branches have been registered.</span>
		@endif

	</p>
</div>

<div class="field">
	<label class="label">
		Permissions
	</label>
</div>

<table class="table is-striped is-bordered">
	@foreach (permissions() as $permission)
		<tbody>
			<tr>
				<td>
					<p class="control">
						<label class="checkbox">
							<input type="checkbox" name="permission_id[]" value="{{ $permission->id }}" />
							{{ $permission->name }}
						</label>
					</p>
				</td>
				<td>{{ $permission->description }}</td>
			</tr>
		</tbody>
	@endforeach
</table>
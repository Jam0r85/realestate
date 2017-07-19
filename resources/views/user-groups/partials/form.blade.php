<div class="field">
	<label class="label" for="name">Name</label>
	<p class="control">
		<input type="text" name="name" class="input" value="{{ isset($group) ? $group->name : null }}" />
	</p>
</div>
<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="userOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userOptionsDropdown">
		<a class="dropdown-item" href="{{ route('branches.show', [$branch->id, 'edit-details']) }}">
			Edit Branch Details
		</a>
	</div>
</div>
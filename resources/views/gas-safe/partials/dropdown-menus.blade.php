<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="gasSafeptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="gasSafeptionsDropdown">
		<a class="dropdown-item" href="{{ route('gas-safe.show', [$reminder->id, 'edit-details']) }}">
			Edit Reminder Details
		</a>
	</div>
</div>

<div class="btn-group">
	<button class="btn btn-danger dropdown-toggle" type="button" id="gasSafectionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Actions
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="gasSafectionsDropdown">
		<a class="dropdown-item" href="{{ route('gas-safe.show', [$reminder->id, 'delete-reminder']) }}">
			Delete Reminder
		</a>
	</div>
</div>
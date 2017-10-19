<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="gasSafeptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="gasSafeptionsDropdown">
		<a class="dropdown-item" href="{{ route('gas-safe.show', [$reminder->id, 'edit-details']) }}">
			Edit Reminder Details
		</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="{{ route('gas-safe.show', [$reminder->id, 'reminder-status']) }}">
			Reminder Status
		</a>
	</div>
</div>
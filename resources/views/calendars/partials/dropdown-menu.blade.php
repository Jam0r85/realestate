<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="calendarOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="calendarOptionsDropdown">
		<a class="dropdown-item" href="{{ route('calendars.show', [$calendar->id, 'edit-details']) }}">
			Edit Calendar Details
		</a>
	</div>
</div>
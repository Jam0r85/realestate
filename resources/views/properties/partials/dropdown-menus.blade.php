<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="propertyOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="propertyOptionsDropdown">
		<a class="dropdown-item" href="{{ route('properties.show', [$property->id, 'edit-details']) }}">
			Edit Property Details
		</a>
		<a class="dropdown-item" href="{{ route('properties.show', [$property->id, 'edit-owners']) }}">
			Manage Owners
		</a>
		<a class="dropdown-item" href="{{ route('properties.show', [$property->id, 'statement-settings']) }}">
			Rental Statement Settings
		</a>
	</div>
</div>

<div class="btn-group">
	<button class="btn btn-danger dropdown-toggle" type="button" id="propertyActionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Actions
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="propertyActionsDropdown">
		<a class="dropdown-item" href="{{ route('properties.show', [$property->id, 'archive-property']) }}">
			Archive property
		</a>
	</div>
</div>
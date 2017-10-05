<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="propertyOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="propertyOptionsDropdown">
		<a class="dropdown-item" href="{{ route('properties.show', [$property->id, 'edit-details']) }}" title="Edit Property Details">
			Edit Property Details
		</a>
		<a class="dropdown-item" href="{{ route('properties.show', [$property->id, 'edit-owners']) }}" title="Manage Owners">
			Manage Owners
		</a>
		<a class="dropdown-item" href="{{ route('properties.show', [$property->id, 'statement-settings']) }}" title="Rental Statement Settings">
			Rental Statement Settings
		</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="{{ route('properties.show', [$property->id, 'archive-property']) }}" title="Archive Property">
			Archive property
		</a>
	</div>
</div>
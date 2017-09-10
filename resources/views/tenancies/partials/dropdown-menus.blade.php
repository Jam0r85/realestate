<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="tenanciesOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="tenanciesOptionsDropdown">
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'new-tenancy-agreement']) }}">
			New Tenancy Agreement
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'new-rent-amount']) }}">
			Record New Rent Amount
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'edit-tenants']) }}">
			Manage Tenants
		</a>
	</div>
</div>

<div class="btn-group">
	<button class="btn btn-danger dropdown-toggle" type="button" id="tenanciesActionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Actions
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="tenanciesActionsDropdown">
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'vacated-tenants']) }}">
			Tenants Vacated
		</a>
	</div>
</div>
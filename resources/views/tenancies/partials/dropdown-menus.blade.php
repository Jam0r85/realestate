<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="tenanciesOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="tenanciesOptionsDropdown">
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'new-tenancy-agreement']) }}" title="New Tenancy Agreement">
			New Tenancy Agreement
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'new-rent-amount']) }}" title="Record New Rent Amount">
			Record New Rent Amount
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'edit-tenants']) }}" title="Manage Tenants">
			Manage Tenants
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'record-old-statement']) }}" title="Record Old Statement">
			Record Old Statement
		</a>
	</div>
</div>

<div class="btn-group">
	<button class="btn btn-danger dropdown-toggle" type="button" id="tenanciesActionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Actions
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="tenanciesActionsDropdown">
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'tenants-vacated']) }}">
			Tenants Vacated
		</a>
	</div>
</div>
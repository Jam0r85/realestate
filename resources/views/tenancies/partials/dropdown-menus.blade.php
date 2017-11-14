<button type="button" class="btn btn-primary">
	<i class="fa fa-plus"></i> Rent Payment
</button>

<button type="button" class="btn btn-info">
	<i class="fa fa-plus"></i> Statement
</button>

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
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'edit-deposit']) }}" title="Manage Deposit">
			{{ $tenancy->deposit ? 'Manage Deposit' : 'Record Deposit' }}
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'edit-tenants']) }}" title="Manage Tenants">
			Manage the Tenants
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'record-old-statement']) }}" title="Record Old Statement">
			Record Old Statement
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'tenancy-status']) }}" title="Tenants Vacting">
			Update Tenancy Status
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'rent-payments-received']) }}" title="Rent Payments History">
			Rent Payments History
		</a>
	</div>
</div>
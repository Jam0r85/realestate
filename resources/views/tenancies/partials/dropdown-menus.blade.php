<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tenancyRentPaymentModal">
	<i class="fa fa-plus"></i> Rent Payment
</button>

<button type="button" class="btn btn-info" data-toggle="modal" data-target="#tenancyStatementModal">
	<i class="fa fa-plus"></i> Statement
</button>

<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="tenanciesOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="tenanciesOptionsDropdown">
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'new-tenancy-agreement']) }}" title="New Tenancy Agreement">
			<i class="fa fa-plus"></i> New Tenancy Agreement
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'new-rent-amount']) }}" title="Record New Rent Amount">
			<i class="fa fa-plus"></i> Record New Rent Amount
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'edit-deposit']) }}" title="Manage Deposit">
			{!! $tenancy->deposit ? '<i class="fa fa-edit"></i> Manage Deposit' : '<i class="fa fa-plus"></i> Record Deposit' !!}
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'edit-tenants']) }}" title="Manage Tenants">
			<i class="fa fa-users"></i> Manage the Tenants
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'record-old-statement']) }}" title="Record Old Statement">
			<i class="fa fa-plus"></i> Record Old Statement
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'tenancy-status']) }}" title="Tenants Vacting">
			<i class="fa fa-edit"></i> Update Tenancy Status
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'rent-payments-received']) }}" title="Rent Payments History">
			<i class="fa fa-history"></i> Rent Payments History
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'statements']) }}" title="Statements History">
			<i class="fa fa-history"></i> Statements History
		</a>
	</div>
</div>
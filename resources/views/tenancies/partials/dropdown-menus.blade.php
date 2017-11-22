<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tenancyRentPaymentModal">
	<i class="fa fa-plus"></i> Rent Payment
</button>

<button type="button" class="btn btn-info" data-toggle="modal" data-target="#tenancyStatementModal">
	<i class="fa fa-plus"></i> Statement
</button>

<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="tenanciesOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="fa fa-cogs"></i> Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="tenanciesOptionsDropdown">
		<a class="dropdown-item" href="#!" title="New Rent Amount" data-toggle="modal" data-target="#tenancyNewRentAmountModal">
			New Rent Amount
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'new-tenancy-agreement']) }}" title="New Tenancy Agreement">
			New Tenancy Agreement
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'record-old-statement']) }}" title="Record Old Statement">
			Record Old Statement
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'edit-tenants']) }}" title="Manage Tenants">
			Manage the Tenants
		</a>
		<a class="dropdown-item" href="{{ route('tenancies.show', [$tenancy->id, 'tenancy-status']) }}" title="Tenants Vacting">
			Update Tenancy Status
		</a>
	</div>
</div>
@if ($tenancy->trashed())

	<span class="badge badge-secondary">
		Archived
	</span>

@else

	@if (!is_null($tenancy->vacated_on) && ($tenancy->vacated_on <= \Carbon\Carbon::now()))
		<span class="badge badge-danger">
			Vacated
		</span>
	@endif

	@if (!is_null($tenancy->vacated_on) && ($tenancy->vacated_on > \Carbon\Carbon::now()))
		<span class="badge badge-warning">
			Vacating
		</span>
	@endif

	@if (is_null($tenancy->vacated_on))

		<span class="badge badge-success">
			Active
		</span>

		@if (!$tenancy->deposit)

			<span class="badge badge-warning">
				No Deposit
			</span>

		@endif

	@endif

@endif
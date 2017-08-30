@if ($tenancy->vacated_on)

	@if ($tenancy->vacated_on <= \Carbon\Carbon::now())

		<div class="notification is-danger">
			Tenants vacated on <b>{{ date_formatted($tenancy->vacated_on) }}</b>
		</div>

	@else

		<div class="notification is-info">
			Tenants planned to vacate on {{ date_formatted($tenancy->vacated_on) }}
		</div>

	@endif

@endif
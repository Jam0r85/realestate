<div class="card text-white text-center 
	@if ($tenancy->present()->rentBalance >= $tenancy->present()->rentAmount)
		bg-success
	@elseif ($tenancy->present()->rentBalance > 0 && $tenancy->present()->rentBalance < $tenancy->present()->rentAmount)
		bg-info
	@elseif ($tenancy->present()->rentBalance < 0)
		bg-danger
	@else 
		bg-primary
	@endif
		">
	<div class="card-body">
		<h2 class="card-title">
			{{ money_formatted($tenancy->rent_balance) }}
		</h2>
		<p class="card-text">
			Rent Balance
		</p>
	</div>
</div>
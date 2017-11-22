<div class="card text-white text-center 
	@if (!$tenancy->deposit)
		bg-secondary
	@elseif ($tenancy->deposit->balance != $tenancy->deposit->amount)
		bg-warning
	@else
		bg-success
	@endif
		">
	<div class="card-body">
		<h2 class="card-title">
			{{ currency($tenancy->deposit ? $tenancy->deposit->balance : 0) }}
		</h2>
		<p class="card-text">
			Deposit Balance
		</p>
	</div>
</div>
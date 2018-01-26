@if ($tenancy->deposit)
	<div class="card text-white text-center {{ $tenancy->present()->depositBalanceCardBackground }}">
		<div class="card-body">
			<h2 class="card-title">
				{{ $tenancy->present()->depositBalance }}
			</h2>
			<p class="card-text">
				Deposit Balance
			</p>
		</div>
	</div>
@endif
@if (!$tenancy->currentRent)

	<div class="card text-white text-center bg-secondary">
		<div class="card-body">
			<h4 class="card-title">
				No Rent Amount Set
			</h4>
			<p class="card-text">
				Rent Balance
			</p>
		</div>
	</div>

@else

	<div class="card text-white text-center @if ($tenancy->getRentBalance() >= $tenancy->currentRent->amount) bg-success @elseif ($tenancy->getRentBalance() > 0 && $tenancy->getRentBalance() < $tenancy->currentRent->amount) bg-info @elseif ($tenancy->getRentBalance() < 0) bg-danger @else bg-primary @endif">
		<div class="card-body">
			<h4 class="card-title">
				{{ currency($tenancy->getRentBalance()) }}
			</h4>
			<p class="card-text">
				Rent Balance
			</p>
		</div>
	</div>

@endif
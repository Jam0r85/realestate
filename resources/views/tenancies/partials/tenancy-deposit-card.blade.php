@if (!$tenancy->deposit)

	<div class="card text-white text-center bg-secondary">
		<div class="card-body">
			<h4 class="card-title">
				No Deposit Recorded
			</h4>
			<p class="card-text">
				Deposit Balance
			</p>
		</div>
	</div>

@else

	<div class="card text-white text-center @if ($tenancy->deposit->balance != $tenancy->deposit->amount) bg-warning @else bg-success @endif">
		<div class="card-body">
			<h4 class="card-title">
				{{ currency($tenancy->deposit->balance) }}
			</h4>
			<p class="card-text">
				Deposit Balance
			</p>
		</div>
	</div>

@endif
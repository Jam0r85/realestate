<div class="card mb-5">
	<h4 class="card-header">
		{{ \Carbon\Carbon::now()->format('F Y') }} Income
	</h4>
	<div class="list-group list-group-flush">
		<div class="list-group-item">
			<span class="float-right">
				{{ currency($commission) }}
			</span>
			Commission
			<br /><small class="text-muted">Management, letting and re-letting fees</small>
		</div>
		<div class="list-group-item">
			<span class="float-right">
				{{ currency($invoice_income) }}
			</span>
			Invoice Income
			<br /><small class="text-muted">Application invoices, sale invoices, etc</small>
		</div>
		<div class="list-group-item">
			<span class="float-right">
				{{ currency($rent_received) }}
			</span>
			Rent Received
		</div>
	</div>
</div>
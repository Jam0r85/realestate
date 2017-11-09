<div class="card mb-5">
	<h4 class="card-header">
		<a href="{{ route('invoices.index') }}?month={{ date('m') }}&year={{ date('Y') }}">
			<span class="float-right text-muted">
				{{ \Carbon\Carbon::now()->format('F Y') }}
			</span>
		</a>
		Income
	</h4>
	<div class="list-group list-group-flush">
		<div class="list-group-item">
			<span class="float-right">
				{{ currency($commission_total) }}
			</span>
			Commission
			<br /><small class="text-muted">Management, letting and re-letting fees</small>
		</div>
		<div class="list-group-item">
			<span class="float-right">
				{{ currency($invoice_total) }}
			</span>
			Invoice Income
			<br /><small class="text-muted">Application invoices, sale invoices, etc</small>
		</div>
		<div class="list-group-item">
			<span class="float-right">
				{{ currency($commission_total + $invoice_total) }}
			</span>
			Combined Income
		</div>
		<div class="list-group-item">
			<span class="float-right">
				{{ currency($rent_received) }}
			</span>
			Rent Received
		</div>
	</div>
</div>
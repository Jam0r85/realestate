<div class="card mb-3">

	@component('partials.card-header')
		<a href="{{ route('invoices.index') }}?month={{ date('m') }}&year={{ date('Y') }}">
			<span class="float-right text-muted">
				{{ \Carbon\Carbon::now()->format('F Y') }}
			</span>
		</a>
		Income
	@endcomponent
	
	<div class="list-group list-group-flush">
		<div class="list-group-item">
			<span class="float-right">
				{{ money_formatted($commission_total) }}
			</span>
			Commission
			<br /><small class="text-muted">Management, letting and re-letting fees</small>
		</div>
		<div class="list-group-item">
			<span class="float-right">
				{{ money_formatted($invoice_total) }}
			</span>
			Invoice Income
			<br /><small class="text-muted">Application invoices, sale invoices, etc</small>
		</div>
		<div class="list-group-item">
			<span class="float-right">
				{{ money_formatted($commission_total + $invoice_total) }}
			</span>
			Combined Income
		</div>
		<div class="list-group-item">
			<span class="float-right">
				{{ money_formatted($rent_received) }}
			</span>
			Rent Received
		</div>
	</div>
</div>
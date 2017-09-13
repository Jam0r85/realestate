<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="invoiceOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="invoiceOptionsDropdown">
		<a class="dropdown-item" href="{{ route('invoices.show', [$invoice->id, 'edit-details']) }}">
			Edit Invoice Details
		</a>
		<a class="dropdown-item" href="{{ route('invoices.show', [$invoice->id, 'record-payment']) }}" title="Record Payment">
			Record Payment
		</a>
		<a class="dropdown-item" href="{{ route('downloads.invoice', $invoice->id) }}" title="Download Invoice" target="_blank">
			Download as PDF
		</a>
	</div>
</div>

<div class="btn-group">
	<button class="btn btn-danger dropdown-toggle" type="button" id="invoiceActionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Actions
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="invoiceActionsDropdown">
		<a class="dropdown-item" href="{{ route('invoices.show', [$invoice->id, 'archive-invoice']) }}">
			Archive Invoice
		</a>
	</div>
</div>
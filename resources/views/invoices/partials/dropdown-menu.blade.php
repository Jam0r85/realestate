<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="invoiceOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="invoiceOptionsDropdown">
		<a class="dropdown-item" href="{{ route('invoices.show', [$invoice->id, 'edit-details']) }}">
			Invoice Details
		</a>
		<a class="dropdown-item" href="{{ route('invoices.show', [$invoice->id, 'archive-invoice']) }}">
			Invoice Status
		</a>
		<a class="dropdown-item" href="{{ route('invoices.show', [$invoice->id, 'new-invoice-item']) }}" title="New Invoice Item">
			New Invoice Item
		</a>
		<a class="dropdown-item" href="{{ route('invoices.show', [$invoice->id, 'record-payment']) }}" title="Record Payment">
			Record Payment
		</a>
		<a class="dropdown-item" href="{{ route('downloads.invoice', $invoice->id) }}" title="Download Invoice" target="_blank">
			Download as PDF
		</a>
		<div class="dropdown-divider"></div>
	</div>
</div>
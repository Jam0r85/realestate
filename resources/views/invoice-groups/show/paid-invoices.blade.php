@include('invoices.partials.invoices-table', [
	'invoices' => $invoices = $group->paidInvoices()->with('property','invoiceGroup','users')->paginate()
])

@include('partials.pagination', [
	'collection' => $invoices
])
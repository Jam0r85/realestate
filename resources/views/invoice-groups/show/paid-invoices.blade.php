@include('invoices.partials.invoices-table', [
	'invoices' => $invoices = $group->paidInvoices()->paginate()
])

@include('partials.pagination', [
	'collection' => $invoices
])
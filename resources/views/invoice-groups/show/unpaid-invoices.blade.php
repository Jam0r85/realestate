@include('invoices.partials.invoices-table', [
	'invoices' => $invoices = $group->unpaidInvoices()->paginate()
])

@include('partials.pagination', [
	'collection' => $invoices
])
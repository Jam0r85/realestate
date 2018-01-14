@include('invoices.partials.invoices-table', [
	'invoices' => $invoices = $group->unpaidInvoices()->with('property','users')->paginate()
])

@include('partials.pagination', [
	'collection' => $invoices
])
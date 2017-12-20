@include('invoices.partials.invoices-table', [
	'invoices' => $invoices = $group->invoices()->paid()->paginate()
])

@include('partials.pagination', [
	'collection' => $invoices
])
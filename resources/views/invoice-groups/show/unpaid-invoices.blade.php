@include('invoices.partials.invoices-table', [
	'invoices' => $invoices = $group->invoices()->unpaid()->paginate()
])

@include('partials.pagination', [
	'collection' => $invoices
])
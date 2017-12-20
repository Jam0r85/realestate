@include('invoices.partials.invoices-table', [
	'invoices' => $group->invoices()->unpaid()->paginate()
])

@include('partials.pagination', [
	'collection' => $group->invoices()->unpaid()->paginate()
])
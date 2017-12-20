@include('invoices.partials.invoices-table', [
	'invoices' => $group->invoices()->paid()->paginate()
])

@include('partials.pagination', [
	'collection' => $group->invoices()->paid()->paginate()
])
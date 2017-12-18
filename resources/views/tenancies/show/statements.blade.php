@include('statements.partials.statements-table', [
	'statements' => $tenancy->statements()->with('expenses','payments','invoices','invoices.items','invoices.items.taxRate')->paginate()
])

@include('partials.pagination', [
	'collection' => $tenancy->statements()->paginate()
])
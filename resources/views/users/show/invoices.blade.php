@include('invoices.partials.invoices-table', [
	'invoices' => $invoices = $user->invoices()->with('users','property','items','items.taxRate','invoiceGroup')->paginate()
])

@include('partials.pagination', ['collection' => $invoices])
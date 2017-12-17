@include('invoices.partials.invoices-table', [
	'invoices' => $property->invoices()->with('property','items','items.taxRate','invoiceGroup','users')->paginate()
])

@include('partials.pagination', [
	'collection' => $property->invoices()->paginate()
])
@include('invoices.partials.invoices-table', ['invoices' => $user->invoices()->with('users','property','items','items.taxRate','invoiceGroup')->paginateFilter()])

@include('partials.pagination', ['collection' => $user->invoices()->paginateFilter()])
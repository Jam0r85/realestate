@include('invoices.partials.invoices-table', ['invoices' => $user->invoices()->with('users','property','items','items.taxRate','invoiceGroup')->paginate()])

@include('partials.pagination', ['collection' => $user->invoices()->paginate()])
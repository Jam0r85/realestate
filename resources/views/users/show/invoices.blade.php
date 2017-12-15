@include('invoices.partials.invoices-table', ['invoices' => $user->invoices])

@include('partials.pagination', ['collection' => $user->invoices])
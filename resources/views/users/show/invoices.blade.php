@include('invoices.partials.invoices-table', ['invoices' => $user->invoices()->paginateFilter()])

@include('partials.pagination', ['collection' => $user->invoices()->paginateFilter()])
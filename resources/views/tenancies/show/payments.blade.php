@include('payments.partials.payments-table', [
	'payments' => $tenancy->rent_payments()->with('method','users','parent')->paginate()
])

@include('partials.pagination', [
	'collection' => $tenancy->rent_payments()->paginate()
])
@include('payments.partials.payments-table', [
	'payments' => $payments = $user->payments()->with('method','users')->paginate()
])

@include('partials.pagination', ['collection' => $payments])
@include('statement-payments.partials.statement-payments-table', [
	'payments' => $payments = $account->statement_payments()->with('statement','statement.tenancy','statement.tenancy.property','bank_account','parent')->paginate()
])

@include('partials.pagination', [
	'collection' => $payments
])
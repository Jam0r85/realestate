@include('statement-payments.partials.statement-payments-table', [
	'payments' => $account->statement_payments()->with('statement','statement.tenancy','statement.tenancy.property','bank_account','parent')->paginate()
])

@include('partials.pagination', [
	'collection' => $account->statement_payments()->paginate()
])
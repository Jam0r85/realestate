@include('statement-payments.partials.statement-payments-table', ['payments' => $account->statement_payments()->with('statement','bank_account')->paginate()])

@include('partials.pagination', ['collection' => $account->statement_payments()->paginate()])
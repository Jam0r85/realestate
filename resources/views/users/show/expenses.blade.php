@include('expenses.partials.expenses-table', [
	'expenses' => $expenses = $user->expenses()->with('property','contractor')->paginate()
])

@include('partials.pagination', ['collection' => $expenses])
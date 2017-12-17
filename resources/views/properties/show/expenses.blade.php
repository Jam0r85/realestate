@include('expenses.partials.expenses-table', [
	'expenses' => $property->expenses()->with('documents','property','contractor')->paginate()
])

@include('partials.pagination', [
	'collection' => $property->expenses()->paginate()
])
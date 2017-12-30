@component('partials.alerts.info')
	This user has been assigned as contractor for the expenses below.
@endcomponent

@include('expenses.partials.expenses-table', [
	'expenses' => $expenses = $user->expenses()->with('property','contractor','documents')->paginate()
])

@include('partials.pagination', [
	'collection' => $expenses
])
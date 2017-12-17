@include('statements.partials.statements-table', [
	'statements' => $property->statements()->with('tenancy','tenancy.property','payments')->paginate()
])

@include('partials.pagination', [
	'collection' => $property->statements()->paginate()
])
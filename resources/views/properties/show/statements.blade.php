@include('statements.partials.statements-table', [
	'statements' => $statements = $property->statements()->with('tenancy','tenancy.property','payments')->paginate()
])

@include('partials.pagination', [
	'collection' => $statements
])
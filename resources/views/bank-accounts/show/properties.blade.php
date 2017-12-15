@include('properties.partials.properties-table', [
	'properties' => $account->properties()->with('owners')->get()
])
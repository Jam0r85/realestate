@component('partials.alerts.info')
	@icon('info') The properties that this bank account is set as the default payment method for.
@endcomponent

@include('properties.partials.properties-table', [
	'properties' => $account->properties()->with('owners')->get()
])
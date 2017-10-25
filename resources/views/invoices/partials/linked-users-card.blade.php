<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Linked Users
	@endcomponent

	@include('partials.bootstrap.users-list-group', ['users' => $invoice->users])
	
</div>
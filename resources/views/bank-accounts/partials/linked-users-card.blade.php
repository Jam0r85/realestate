<div class="card mb-3">

	@component('partials-header')
		Linked Users
	@endcomponent

	@component('partials.bootstrap.users-list-group', ['users' => $account->users])

</div>
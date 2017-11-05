<div class="card mb-3">

	@component('partials.card-header')
		Linked Users
	@endcomponent

	@include('partials.bootstrap.users-list-group', ['users' => $account->users])

</div>
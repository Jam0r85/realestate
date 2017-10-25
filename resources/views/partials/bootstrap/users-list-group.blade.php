@if (count($users))

	<ul class="list-group list-group-flush">
		@each('partials.bootstrap.user-list-group-item', $users, 'user')
	</ul>

@else

	@component('partials.alerts.warning')
		No users found.
		@slot('style')
			border-0 rounded-0 mb-0
		@endslot
	@endcomponent

@endif
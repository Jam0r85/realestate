@if (count($users))

	<ul class="list-group list-group-flush">
		@each('partials.bootstrap.user-list-group-item', $users, 'user')
	</ul>

@else

	<div class="card-body">
		<div class="alert alert-warning">
			No users found.
		</div>
	</div>

@endif
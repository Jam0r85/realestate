<div class="card {{ count($account->users) ? 'bg-success' : 'bg-danger' }} mb-3">
	<div class="card-header text-white">
		<i class="fa fa-cogs"></i> Linked Users
	</div>
	@if (!count($account->users))
		<div class="card-body text-white">
			<b>No linked users!</b><br />No users have been linked to this account yet.
		</div>
	@else
		<ul class="list-group list-group-flush">
			@foreach ($account->users as $user)
				<li class="list-group-item">
					<a href="{{ route('users.show', $user->id) }}" title="{{ $user->name }}">
						{{ $user->name }}
					</a>
				</li>
			@endforeach
		</ul>
	@endif
</div>
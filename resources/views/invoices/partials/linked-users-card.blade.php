<div class="card {{ count($invoice->users) ? 'bg-success' : 'bg-danger' }} mb-3">
	<div class="card-header text-white">
		<i class="fa fa-users"></i> Linked Users
	</div>
	@if (!count($invoice->users))
		<div class="card-body text-white">
			<b>No linked users!</b><br />No users have been linked to this invoice yet.
		</div>
	@else
		<ul class="list-group list-group-flush">
			@foreach ($invoice->users as $user)
				<li class="list-group-item">
					<a href="{{ route('users.show', $user->id) }}" title="{{ $user->name }}">
						{{ $user->name }}
						@if ($user->email)
							({{ $user->email }})
						@endif
					</a>
				</li>
			@endforeach
		</ul>
	@endif
</div>
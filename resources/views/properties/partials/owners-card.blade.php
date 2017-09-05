<div class="card {{ count($property->owners) ? 'bg-success' : 'bg-danger' }} mb-3">
	<div class="card-header text-white">
		<i class="fa fa-users"></i> Owners
	</div>
	@if (!count($property->owners))
		<div class="card-body text-white">
			<b>No owners!</b><br />No users have been set as owners of this property yet.
		</div>
	@else
		<ul class="list-group list-group-flush">
			@foreach ($property->owners as $user)
				<li class="list-group-item">
					<a href="{{ route('users.show', $user->id) }}" title="{{ $user->name }}">
						{{ $user->name }}
					</a>
				</li>
			@endforeach
		</ul>
	@endif
</div>
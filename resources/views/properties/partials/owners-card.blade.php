<div class="card @if (!count($property->owners)) border-danger @else border-success @endif mb-3">
	<h5 class="card-header text-white @if (!count($property->owners)) bg-danger @else bg-success @endif">
		<i class="fa fa-users"></i> Owners
	</h5>

	@if (!count($property->owners))

		<div class="card-body">
			No users have been assigned as owners of this property yet.
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
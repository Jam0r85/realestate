@if (count($users))
	<ul class="list-inline m-0">
		@foreach ($users as $user)
			<li class="list-inline-item">
				<a href="{{ route('users.show', $user->id) }}" title="View {{ $user->name }}'s' Profile">
					{{ $user->name }}
				</a>
			</li>
		@endforeach
	</ul>
@endif
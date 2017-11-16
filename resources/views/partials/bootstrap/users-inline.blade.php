@if (count($users))
	<ul class="list-inline m-0">
		@foreach ($users as $user)
			<li class="list-inline-item">
				<a href="{{ route('users.show', $user->id) }}">
					{{ $user->present()->fullName }}
				</a>
			</li>
		@endforeach
	</ul>
@endif
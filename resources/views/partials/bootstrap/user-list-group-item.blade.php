<li class="list-group-item">

	{{-- User Name --}}
	<p class="lead mb-0">
		<a href="{{ route('users.show', $user->id) }}" title="View {{ $user->name }}'s Profile">
			{{ $user->name }}
		</a>
	</p>
	{{-- End User Name --}}

	{{-- User E-Mail --}}
	@if ($user->email)
		<span class="d-block">
			<i class="fa fa-envelope fa-fw"></i> {{ $user->email }}
		</span>
	@endif
	{{-- End User E-Mail --}}

	{{-- User Phone Number --}}
	@if ($user->phone_number)
		<span class="d-block">
			<i class="fa fa-mobile fa-fw"></i> {{ $user->phone_number }}
		</span>
	@endif
	{{-- End User Phone Number --}}

</li>
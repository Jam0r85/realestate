<div class="card mb-3">
	<h5 class="card-header">
		<i class="fa fa-users"></i> Tenants
	</h5>

	@if (!count($tenancy->tenants))

		<div class="card-body">
			<p class="card-text">
				No users have been added as tenants to this tenancy.
			</p>
		</div>

	@else

		<ul class="list-group list-group-flush">
			@foreach ($tenancy->tenants as $user)
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
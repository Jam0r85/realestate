<div class="card {{ count($tenancy->tenants) ? 'bg-success' : 'bg-danger' }} mb-3">
	<div class="card-header text-white">
		<i class="fa fa-users"></i> Tenants
	</div>
	@if (!count($tenancy->tenants))
		<div class="card-body text-white">
			<b>No tenants!</b><br />No users have been added as tenants to this tenancy yet.
		</div>
	@else
		<ul class="list-group list-group-flush">
			@foreach ($tenancy->tenants as $user)
				<li class="list-group-item">
					<a href="{{ route('users.show', $user->id) }}" title="{{ $user->name }}">
						{{ $user->name }}
					</a>
				</li>
			@endforeach
		</ul>
	@endif
</div>
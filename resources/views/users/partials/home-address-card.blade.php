<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-home"></i> Home Address
	</div>
	<div class="card-body">

		@if (count($tenancy = $user->tenancies()->isActive()->first()))

			<a href="{{ route('properties.show', $tenancy->property->id) }}">
				{{ $tenancy->property->name }}
			</a>

		@else

			@if ($user->home)

				<a href="{{ route('properties.show', $user->property_id) }}">
					{{ $user->home->name }}
				</a>

			@else

				<p class="card-text">User has not been assigned a home.</p>

			@endif

		@endif

	</div>
</div>
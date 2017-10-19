<div class="card mb-3">
	<h5 class="card-header">
		<i class="fa fa-home"></i> Current Home Address
	</h5>
	<div class="card-body">

		@if (count($tenancy = $user->tenancies()->isActive()->first()))

			<p class="card-text">
				<a href="{{ route('properties.show', $tenancy->property->id) }}">
					{{ $tenancy->property->name }}
				</a>
			</p>

		@else

			<p class="card-text">

				@if ($user->home)

					<a href="{{ route('properties.show', $user->property_id) }}">
						{{ $user->home->name }}
					</a>

				@else
					User has not been assigned a home.
				@endif

			</p>

		@endif

	</div>
</div>
<div class="card text-white @if ($user->home) bg-success @else bg-danger @endif mb-3">
	<div class="card-header">
		<i class="fa fa-home"></i> Home Address
	</div>
	<div class="card-body">

		@if ($user->home)
			<a href="{{ route('properties.show', $user->property_id) }}">
				{{ $user->home->name }}
			</a>
		@endif

		@if (!$user->home)
			<b>No address set!</b><br />User is currently homeless.
		@endif

	</div>
</div>
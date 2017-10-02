<div class="card mb-3">
	<div class="card-header @if ($user->home) bg-success @else bg-danger @endif text-white">
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
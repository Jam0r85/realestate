<div class="card mb-3">

	@component('partials.card-header')
		System Information
	@endcomponent
	
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $property->branch ? $property->branch->name : '' }}
			@slot('title')
				Branch
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			<a href="{{ route('users.show', $property->owner->id) }}">
				{{ $property->owner->present()->fullName }}</a>
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($property->created_at) }}
			@slot('title')
				Registered
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($property->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
	</ul>
</div>
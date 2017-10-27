<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		System Information
	@endcomponent

	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $user->branch ? $user->branch->name : '-' }}
			@slot('title')
				Registered Branch
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $user->owner ? $user->owner->name : '-' }}
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ datetime_formatted($user->created_at) }}
			@slot('title')
				Registered
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ datetime_formatted($user->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			@slot('title')
				Last Login
			@endslot
		@endcomponent
	</ul>
</div>
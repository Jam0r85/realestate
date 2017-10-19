<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-cogs"></i> System Information
	</div>
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $user->branch ? $user->branch->name : '' }}
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
			{{ date_formatted($user->created_at) }}
			@slot('title')
				Registered
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($user->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			@if (count($user->logins))
				{{ datetime_formatted($user->logins()->first()->created_at) }}
			@else
				-
			@endif
			@slot('title')
				Last Login
			@endslot
		@endcomponent
	</ul>
</div>
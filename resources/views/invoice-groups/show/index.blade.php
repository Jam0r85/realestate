<div class="card mb-3">
	@component('partials.card-header')
		System Information
	@endcomponent
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $group->branch->name }}
			@slot('title')
				Registered Branch
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($group->created_at) }}
			@slot('title')
				Registered
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ datetime_formatted($group->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
	</ul>
</div>
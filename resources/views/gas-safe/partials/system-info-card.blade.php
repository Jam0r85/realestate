<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		System Information
	@endcomponent

	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $gas->property->branch->name }}
			@slot('title')
				Branch
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			<a href="{{ route('users.show', $gas->owner->id) }}">
				{{ $gas->owner->name }}
			</a>
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ datetime_formatted($gas->created_at) }}
			@slot('title')
				Created
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ datetime_formatted($gas->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
	</ul>
</div>
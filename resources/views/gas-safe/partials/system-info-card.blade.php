<div class="card mb-3">
	<h5 class="card-header">
		<i class="fa fa-cogs"></i> System Information
	</h5>
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $reminder->owner ? $reminder->owner->name : '-' }}
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($reminder->created_at) }}
			@slot('title')
				Created
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($reminder->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
	</ul>
</div>
<div class="card mb-3">
	<h5 class="card-header">
		<i class="fa fa-info-circle"></i> Gas Safe Information
	</h5>
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $reminder->property->name }}
			@slot('title')
				Property
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ implode(', ', $reminder->property->owners->pluck('name')->toArray()) }}
			@slot('title')
				Property Owners
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($reminder->expires_on) }}
			@slot('title')
				Expiry Date
			@endslot
		@endcomponent
	</ul>
</div>
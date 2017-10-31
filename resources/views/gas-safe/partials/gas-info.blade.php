<div class="card mb-3">

	@component('partials.card-header')
		Gas Inspection Details
	@endcomponent
	
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $gas->property->name }}
			@slot('title')
				Property
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			@include('partials.bootstrap.users-inline', ['users' => $gas->property->owners])
			@slot('title')
				Property Owners
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($gas->expires_on) }}
			@slot('title')
				Expiry Date
			@endslot
		@endcomponent
	</ul>
</div>
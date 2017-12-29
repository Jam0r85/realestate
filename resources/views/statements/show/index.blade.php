<div class="card mb-3">
	@component('partials.card-header')
		Statement Details
	@endcomponent
	<ul class="list-group list-group-flush">
		@component('partials.list-group-item')
			<a href="{{ route('tenancies.show', $statement->tenancy_id) }}">
				{{ $statement->tenancy->present()->name }}
			</a>
			@slot('title')
				Tenancy
			@endslot
		@endcomponent
		@component('partials.list-group-item')
			<a href="{{ route('properties.show', $statement->tenancy->property_id) }}">
				{{ $statement->tenancy->property->present()->fullAddress }}
			</a>
			@slot('title')
				Property
			@endslot
		@endcomponent
	</ul>
</div>
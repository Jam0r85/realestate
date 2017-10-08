<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-info-circle"></i> Tenancy Details
	</div>
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			<a href="{{ route('properties.show', $tenancy->property_id) }}" title="{{ $tenancy->property->name }}">
				{{ $tenancy->property->name }}
			</a>
			@slot('title')
				Property
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->first_agreement ? date_formatted($tenancy->first_agreement->starts_at) : '' }}
			@slot('title')
				Started
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->next_statement_start_date ? date_formatted($tenancy->next_statement_start_date) : '-' }}
			@slot('title')
				Next Statement Due
			@endslot
		@endcomponent
	</ul>
</div>
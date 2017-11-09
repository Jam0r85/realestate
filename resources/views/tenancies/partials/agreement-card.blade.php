<div class="card mb-3">

	@component('partials.card-header')
		Agreement Details
	@endcomponent

	@if (!$tenancy->current_agreement)

		<div class="card-body">
			<p class="card-text">
				No tenancy agreement found.
			</p>
		</div>

	@else

		<ul class="list-group list-group-flush">
			@component('partials.bootstrap.list-group-item')
				{{ date_formatted($tenancy->current_agreement->starts_at) }}
				@slot('title')
					Start Date
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ $tenancy->current_agreement->length_formatted }}
				@slot('title')
					Length
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ $tenancy->current_agreement->ends_at_formatted }}
				@slot('title')
					End Date
				@endslot
			@endcomponent
		</ul>

	@endif

</div>
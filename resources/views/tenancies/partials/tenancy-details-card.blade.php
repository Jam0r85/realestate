<div class="card mb-3">

	@component('partials..card-header')
		Tenancy Details
	@endcomponent

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
			@if (count($tenancy->property->owners))
				<ul class="list-unstyled">
					@foreach ($tenancy->property->owners as $user)
						<li>
							<a href="{{ route('users.show', $user->id) }}">
								{{ $user->name }}
							</a>
						</li>
					@endforeach
				</ul>
			@endif
			@slot('title')
				{{ str_plural('Landlord', count($tenancy->property->owners)) }}
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->first_agreement ? date_formatted($tenancy->first_agreement->starts_at) : '' }}
			@slot('title')
				Started
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($tenancy->nextStatementDate()) }}
			@slot('title')
				Next Statement Due
			@endslot
		@endcomponent
	</ul>
</div>
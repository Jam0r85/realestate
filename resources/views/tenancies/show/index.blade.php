<div class="card mb-3">
	@component('partials.card-header')
		Tenants
	@endcomponent

	@include('users.partials.users-table', ['users' => $tenancy->users])
</div>

<div class="card mb-3">
	@component('partials..card-header')
		Tenancy Details
	@endcomponent
	<ul class="list-group list-group-flush">		
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->first_agreement ? date_formatted($tenancy->first_agreement->starts_at) : '' }}
			@slot('title')
				Started
			@endslot
		@endcomponent
	</ul>
</div>

<div class="card mb-3">
	@component('partials.card-header')
		System Information
	@endcomponent

	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->property->branch->name }}
			@slot('title')
				Branch
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			<a href="{{ route('users.show', $tenancy->owner->id) }}">
				{{ $tenancy->owner->name }}
			</a>
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($tenancy->created_at) }}
			@slot('title')
				Registered
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ datetime_formatted($tenancy->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
	</ul>
</div>
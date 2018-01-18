<div class="card mb-3">
	@component('partials.card-header')
		Owners
	@endcomponent

	@include('users.partials.users-table', ['users' => $property->owners])
</div>

<div class="card mb-3">
	@component('partials.card-header')
		Current Residents
	@endcomponent

	@if ($property->getCurrentResidents())
		@include('users.partials.users-table', ['users' => $property->getCurrentResidents()])
	@endif
</div>

<div class="row">
	<div class="col-12 col-lg-6">

		<div class="card mb-3">

			@component('partials.card-header')
				Property Details
			@endcomponent
			
			<ul class="list-group list-group-flush">
				@component('partials.bootstrap.list-group-item')
					{{ $property->house_name }}
					@slot('title')
						House Name
					@endslot
				@endcomponent
				@component('partials.bootstrap.list-group-item')
					{{ $property->house_number }}
					@slot('title')
						House Number
					@endslot
				@endcomponent
				@component('partials.bootstrap.list-group-item')
					{{ $property->address1 }}
					@slot('title')
						Address Line 1
					@endslot
				@endcomponent
				@component('partials.bootstrap.list-group-item')
					{{ $property->address2 }}
					@slot('title')
						Address Line 2
					@endslot
				@endcomponent
				@component('partials.bootstrap.list-group-item')
					{{ $property->address3 }}
					@slot('title')
						Address Line 3
					@endslot
				@endcomponent
				@component('partials.bootstrap.list-group-item')
					{{ $property->town }}
					@slot('title')
						Town
					@endslot
				@endcomponent
				@component('partials.bootstrap.list-group-item')
					{{ $property->county }}
					@slot('title')
						County
					@endslot
				@endcomponent
				@component('partials.bootstrap.list-group-item')
					{{ $property->postcode }}
					@slot('title')
						Postcode
					@endslot
				@endcomponent
				@component('partials.bootstrap.list-group-item')
					{{ $property->country }}
					@slot('title')
						Country
					@endslot
				@endcomponent
			</ul>
		</div>

	</div>
	<div class="col-12 col-lg-6">

		<div class="card mb-3">

			@component('partials.card-header')
				Property Further Details
			@endcomponent

			<ul class="list-group list-group-flush">
				@component('partials.bootstrap.list-group-item')
					{{ $property->band ? $property->band->name : '' }}
					@slot('title')
						Tax Band
					@endslot
				@endcomponent
				@component('partials.bootstrap.list-group-item')
					{{ $property->getData('reception_rooms') }}
					@slot('title')
						Reception Rooms
					@endslot
				@endcomponent
				@component('partials.bootstrap.list-group-item')
					{{ $property->getData('bedrooms') }}
					@slot('title')
						Bedrooms
					@endslot
				@endcomponent
				@component('partials.bootstrap.list-group-item')
					{{ $property->getData('bathrooms') }}
					@slot('title')
						Bathrooms
					@endslot
				@endcomponent
			</ul>

		</div>

	</div>
</div>

<div class="card mb-3">

	@component('partials.card-header')
		System Information
	@endcomponent
	
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $property->branch ? $property->branch->name : '' }}
			@slot('title')
				Branch
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			<a href="{{ route('users.show', $property->owner->id) }}">
				{{ $property->owner->present()->fullName }}</a>
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($property->created_at) }}
			@slot('title')
				Registered
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($property->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
	</ul>
</div>
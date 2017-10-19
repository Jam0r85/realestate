<div class="card mb-3">
	<h5 class="card-header">
		<i class="fa fa-home"></i> Property Information
	</h5>
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
	</ul>
</div>
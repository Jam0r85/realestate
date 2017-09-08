<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-building"></i> Branch Information
	</div>
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $branch->name }}
			@slot('title')
				Name
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $branch->email }}
			@slot('title')
				E-Mail Address
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $branch->phone_number }}
			@slot('title')
				Phone
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{!! $branch->address_formatted !!}
			@slot('title')
				Address
			@endslot
		@endcomponent
	</ul>
</div>
@component('partials.bootstrap.list-group-item')
	@if (isset($title))
		@slot('title')
			{{ $title }}
		@endslot
	@endif
	
	{{ $slot }}
@endcomponent